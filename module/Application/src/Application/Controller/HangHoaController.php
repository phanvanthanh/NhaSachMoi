<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\SanPham;
use Application\Model\Entity\PhieuNhap;
use Application\Model\Entity\CtPhieuNhap;
use Application\Model\Entity\GiaXuat;
use Application\Model\Entity\HoaDon;
use Application\Model\Entity\CtHoaDon;
use Zend\View\Model\JsonModel;


class HangHoaController extends AbstractActionController
{
    public function indexAction()
    {
        $return=array();
        $id_kho=$this->AuthService()->getIdKho();      
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        $danh_sach_san_pham=$san_pham_table->getSanPhamAndLoaiSanPhamByArrayConditionAnd2ArrayColumn(array('t1.id_kho'=>$id_kho, 't1.state'=>1), array('id_san_pham', 'ten_san_pham', 'ma_san_pham', 'ton_kho', 'nhan'), array('loai_san_pham'));
        $return['danh_sach_san_pham']=$danh_sach_san_pham;
        return $return;
    }

    public function bangGiaAction(){
    	
    }

    public function themSanPhamAction(){        
        $return=array();
        $form=$this->getServiceLocator()->get('Application\Form\ThemSanPhamForm');
        $return['form']=$form;
        $request=$this->getRequest();
        if($request->isPost()){
            $post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if($form->isValid()){
                $san_pham_moi=new SanPham();
                $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
                $id_kho=$this->AuthService()->getIdKho();
                $user_id=$this->AuthService()->getUserId();
                $san_pham_moi->exchangeArray($post);
                
                // nếu nhập mã vạch
                if($post['ma_vach']){
                    // nếu nhập mã vạch thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$post['ma_vach']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_vach')->setMessages(array('Mã vạch này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                    $san_pham_moi->setIdBarcode(6);
                }
                // ngược lại không nhập mã vạch
                else{
                    $barcode=$this->Barcode()->createBarcode(); 
                    $san_pham_moi->setIdBarcode($barcode['id_barcode']);
                    $san_pham_moi->setMaVach($barcode['ma_vach']);
                }
                // nếu nhập mã sản phẩm
                if($post['ma_san_pham']){
                    // nếu nhập mã sản phẩm thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_san_pham'=>$post['ma_san_pham']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_san_pham')->setMessages(array('Mã sản phẩm này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                }
                else{
                    $ma_san_pham=$san_pham_moi->getMaVach();
                    $san_pham_moi->setMaSanPham($ma_san_pham);
                }

                // nếu loại giá
                if($post['loai_gia']){
                    $san_pham_moi->setGiaNhap(0);
                }
                else{
                    $san_pham_moi->setGiaBia(0);
                    $san_pham_moi->setChietKhau(0);
                }
                // xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){                    
                    $path = "./public/img/orther/product/".$id_kho."/";
                    $pathSave = "/img/orther/product/".$id_kho."/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                }
                else{
                    $pathSave = "/img/default/product/default.png";
                }
                $san_pham_moi->setHinhAnh($pathSave);
                $san_pham_moi->setIdKho($id_kho);
                $san_pham_moi->setTonKho(0);
                $san_pham_moi->setState(1);
                $san_pham_moi->setUserId($user_id);
                $san_pham_table->saveSanPham($san_pham_moi);

                $this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm sản phẩm thành công!');
                return $this->redirect()->toRoute('hang_hoa', array('action'=>'index'));
            }
            else{// form not valid
                $return['form']=$form;
                return $return;
            }
        }
        else{ // not post value
            return $return;
        }
    }

    public function suaSanPhamAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $return=array('id'=>$id);
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        // kiểm tra sản phẩm tồn tại
        $san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id, 'id_kho'=>$id_kho, 'state'=>1), array());
        if(!$san_pham){
            $this->flashMessenger()->addErrorMessage('Sản phẩm không tồn tại');
            return $this->redirect()->toRoute('hang_hoa');
        }
        //tạo form
        $form=$this->getServiceLocator()->get('Application\Form\SuaSanPhamForm');
        $form->setData($san_pham[0]);
        $return['form']=$form;

        $request=$this->getRequest();
        if($request->isPost()){
            $post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if($form->isValid()){
                $san_pham_moi=new SanPham();
                $user_id=$this->AuthService()->getUserId();
                $data=array_merge($san_pham[0], $post);
                $san_pham_moi->exchangeArray($data);
                // nếu sửa mã vạch
                if($san_pham[0]['ma_vach']!=$post['ma_vach'] and $post['ma_vach']){
                    // nếu nhập mã vạch thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$post['ma_vach']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_vach')->setMessages(array('Mã vạch này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                    $san_pham_moi->setIdBarcode(6);
                }
                else{
                    $san_pham_moi->setMaVach($san_pham[0]['ma_vach']);
                }
                // nếu sửa mã sản phẩm
                if($san_pham[0]['ma_san_pham']!=$post['ma_san_pham'] and $post['ma_san_pham']){
                    // nếu nhập mã sản phẩm thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_san_pham'=>$post['ma_san_pham']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_san_pham')->setMessages(array('Mã sản phẩm này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                }
                else{
                    $san_pham_moi->setMaSanPham($san_pham[0]['ma_san_pham']);
                }
                // nếu sửa hình ảnh                
                if($post['hinh_anh'] and $post['hinh_anh']['error']==0){
                    $image=$post['hinh_anh'];
                    // lưu hình mới
                    $path = "./public/img/orther/product/".$id_kho."/";
                    $pathSave = "/img/orther/product/".$id_kho."/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                    $san_pham_moi->setHinhAnh($pathSave);
                    // nếu hình khác default thì xóa
                    if(trim($san_pham[0]['hinh_anh'])!='/img/default/product/default.png'){
                        $path = './public'.$san_pham[0]['hinh_anh'];
                        array_map("unlink", glob($path));
                    }
                    
                }
                else{
                    $san_pham_moi->setHinhAnh($san_pham[0]['hinh_anh']);
                }
                $san_pham_moi->setUserId($user_id);
                $san_pham_table->saveSanPham($san_pham_moi);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật sản phẩm thành công!');
                return $this->redirect()->toRoute('hang_hoa');
            }else{
                $return['form']=$form;
                return $return;
            }
        }else{
            return $return;
        } 
    }

    public function xoaSanPhamAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $user_id=$this->AuthService()->getUserId();
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        // kiểm tra sản phẩm tồn tại
        $san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id, 'id_kho'=>$id_kho), array());
        if(!$san_pham){
            $this->flashMessenger()->addErrorMessage('Sản phẩm với id='.$id.' không tồn tại');
            return $this->redirect()->toRoute('hang_hoa');
        }
        else{
            $san_pham_moi=new SanPham();
            $san_pham_moi->exchangeArray($san_pham[0]);
            // nếu hình khác default thì xóa
            if(trim($san_pham[0]['hinh_anh'])!='/img/default/product/default.png'){
                $path = './public'.$san_pham[0]['hinh_anh'];
                array_map("unlink", glob($path));
            }            
            $san_pham_moi->setHinhAnh('/img/default/product/default.png');
            $san_pham_moi->setState(0);
            $san_pham_moi->setUserId($user_id);
            $san_pham_table->saveSanPham($san_pham_moi);
            $this->flashMessenger()->addSuccessMessage('Xóa sản phẩm thành công!');
            return $this->redirect()->toRoute('hang_hoa');
        }

    }

    public function nhapHangHoaAction(){
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            if(isset($post['id_nha_cung_cap']) and $post['id_nha_cung_cap'] and isset($post['id_san_pham']) and $post['id_san_pham'] and isset($post['so_luong']) and $post['so_luong'] and isset($post['gia_nhap']) and $post['gia_nhap']){
                $id_phieu_nhap='';
                $user_id=$this->AuthService()->getUserId();
                $id_kho=$this->AuthService()->getIdKho();
                $phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\PhieuNhapTable');
                $ct_phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\CtPhieuNhapTable');
                $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
                $kenh_phan_phoi_table=$this->getServiceLocator()->get('Application\Model\KenhPhanPhoiTable');
                $gia_xuat_table=$this->getServiceLocator()->get('Application\Model\GiaXuatTable');
                
                // tạo phiếu nhập và chi tiết phiếu nhập
                foreach ($post['id_san_pham'] as $key => $id_san_pham) {
                    $form=$this->getServiceLocator()->get('Application\Form\NhapHangHoaForm');
                    $data=array();
                    $data['id_nha_cung_cap']=$post['id_nha_cung_cap'];
                    $data['id_san_pham']=$id_san_pham;
                    $data['so_luong']=ceil($post['so_luong'][$key]);
                    if($post['loai_gia'][$key]==1){
                        $loi_nhuan=(float)(((float)$post['gia_bia'][$key]*(float)$post['chiet_khau'][$key])/100);
                        $data['gia_nhap']=ceil((float)$post['gia_bia'][$key]-$loi_nhuan);
                    }
                    else{
                        $data['gia_nhap']=ceil($post['gia_nhap'][$key]);
                    }
                    
                    $form->setData($data);
                    if($form->isValid()){
                        if(!$id_phieu_nhap){
                            $phieu_nhap_moi=new PhieuNhap();
                            $ma_phieu_nhap=$this->TaoMaTuDong()->taoMaPhieuNhap();
                            $phieu_nhap_moi->setMaPhieuNhap($ma_phieu_nhap);
                            $phieu_nhap_moi->setIdUser($user_id);
                            $phieu_nhap_moi->setIdNhaCungCap($post['id_nha_cung_cap']);
                            $date = date('Y-m-d h:i:s a', time());
                            $phieu_nhap_moi->setNgayNhap($date);
                            $phieu_nhap_moi->setState(0);
                            $phieu_nhap_table->savePhieuNhap($phieu_nhap_moi);
                            $phieu_nhap=$phieu_nhap_table->getPhieuNhapByArrayConditionAndArrayColumn(array('ma_phieu_nhap'=>$ma_phieu_nhap), array('id_phieu_nhap'));
                            $id_phieu_nhap=$phieu_nhap[0]['id_phieu_nhap'];
                        }  
                        $ct_phieu_nhap_moi=new CtPhieuNhap();
                        $ct_phieu_nhap_moi->exchangeArray($data);
                        $ct_phieu_nhap_moi->setIdPhieuNhap($id_phieu_nhap);
                        $ct_phieu_nhap_table->saveCtPhieuNhap($ct_phieu_nhap_moi);                   
                    }
                    else{                    
                        // xóa phiếu nhập
                        if($id_phieu_nhap){
                            $phieu_nhap_table->deletePhieuNhap(array('id_phieu_nhap'=>$id_phieu_nhap));
                        }
                        // thông báo lỗi
                        $this->flashMessenger()->addErrorMessage('Lỗi, nhập hàng hóa không thành công');
                        return $this->redirect()->toRoute('hang_hoa', array('action'=>'nhap-hang-hoa'));
           
                    }
                }
                // get danh sách kênh phân phối
                $danh_sach_kenh_phan_phoi=$kenh_phan_phoi_table->getKenhPhanPhoiByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho), array('id_kenh_phan_phoi', 'chiet_khau'));
                // cập nhật lại số lượng và loại giá, giá nhập, giá bìa, chiết khấu trong csdl
                foreach ($post['id_san_pham'] as $key => $id_san_pham) {
                    $san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id_san_pham), array());
                    $san_pham_moi=new SanPham();
                    $san_pham_moi->exchangeArray($san_pham[0]);
                    $san_pham_moi->setLoaiGia($post['loai_gia'][$key]);
                    if($post['loai_gia'][$key]==1){
                        $san_pham_moi->setGiaBia(ceil($post['gia_bia'][$key]));
                        $san_pham_moi->setChietKhau($post['chiet_khau'][$key]);

                        $loi_nhuan=(float)(((float)$post['gia_bia'][$key]*(float)$post['chiet_khau'][$key])/100);
                        $gia_nhap=ceil((float)$post['gia_bia'][$key]-$loi_nhuan);                        
                        $san_pham_moi->setGiaNhap($gia_nhap);
                    }
                    else{
                        $san_pham_moi->setGiaNhap(ceil($post['gia_nhap'][$key]));
                        $san_pham_moi->setGiaBia(0);
                        $san_pham_moi->setChietKhau(0);
                    }
                    $ton_kho=$san_pham[0]['ton_kho'];
                    $so_luong=ceil($post['so_luong'][$key]);
                    $ton_kho+=$so_luong;
                    $san_pham_moi->setTonKho($ton_kho);
                    $san_pham_table->saveSanPham($san_pham_moi);
                    // xóa hết giá xuất
                    $gia_xuat_table->deleteGiaXuat(array('id_san_pham'=>$id_san_pham));
                    // lưu giá xuất mới
                    foreach ($danh_sach_kenh_phan_phoi as $kenh_phan_phoi) {
                        $gia_xuat=0;
                        if($post['loai_gia'][$key]==1){
                            $loi_nhuan=(float)(((float)$post['gia_bia'][$key]*(float)$kenh_phan_phoi['chiet_khau'])/100);
                            $gia_xuat=ceil((float)$post['gia_bia'][$key]-$loi_nhuan);
                        }
                        else{
                            $loi_nhuan=(float)(((float)$post['gia_nhap'][$key]*(float)$kenh_phan_phoi['chiet_khau'])/100);
                            $gia_xuat=ceil((float)$post['gia_nhap'][$key]+$loi_nhuan);
                        }
                        $gia_xuat_moi=new GiaXuat();
                        $gia_xuat_moi->setIdSanPham($id_san_pham);
                        $gia_xuat_moi->setIdKenhPhanPhoi($kenh_phan_phoi['id_kenh_phan_phoi']);
                        $gia_xuat_moi->setGiaXuat($gia_xuat);
                        $gia_xuat_table->saveGiaXuat($gia_xuat_moi);                        
                    }                    
                }
                // lưu thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, nhập hàng thành công!');
                return $this->redirect()->toRoute('ban_hang', array('action'=>'chi-tiet-phieu-nhap', 'id'=>$id_phieu_nhap));
            
            }
            else{
                $this->flashMessenger()->addErrorMessage('Lỗi, không tìm thấy sản phẩm cần nhập');
                return $this->redirect()->toRoute('hang_hoa', array('action'=>'nhap-hang-hoa'));
            }
            
        }
    }   

    public function danhSachNhaCungCapAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $id_kho=$this->AuthService()->getIdKho();
            $nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
            $danh_sach_nha_cung_cap=$nha_cung_cap_table->getNhaCungCapByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 't1.state'=>1), array('id_nha_cung_cap', 'ho_ten', 'di_dong', 'dia_chi'));
            $response=array('error'=>'', 'danh_sach_nha_cung_cap'=>$danh_sach_nha_cung_cap);
            $json = new JsonModel($response);
            return $json;
        }
        else {
            $response=array('error'=>'Phương thức nhập không đúng');
            $json = new JsonModel($response);
            return $json;
        }
    }

    public function danhSachSanPhamAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $id_kho=$this->AuthService()->getIdKho();      
            $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
            $danh_sach_san_pham=$san_pham_table->getSanPhamAndDonViTinhByArrayConditionAnd2ArrayColumn(array('t1.id_kho'=>$id_kho, 't1.state'=>1), array('id_san_pham', 'ten_san_pham', 'ma_san_pham', 'ma_vach', 'loai_gia', 'gia_nhap', 'gia_bia', 'chiet_khau', 'ton_kho'), array('don_vi_tinh'));
            $response=array('error'=>'', 'danh_sach_san_pham'=>$danh_sach_san_pham);
            $json = new JsonModel($response);
            return $json;
        }
        else {
            $response=array('error'=>'Phương thức nhập không đúng');
            $json = new JsonModel($response);
            return $json;
        }
    }

    public function xuatHangHoaAction(){
        $request=$this->getRequest();
        if($request->isPost()){
            $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
            $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
            $ct_hoa_don_table=$this->getServiceLocator()->get('Application\Model\CtHoaDonTable');
            $id_user=$this->AuthService()->getUserId();
            $post=$request->getPost();
            $id_hoa_don='';
            $danh_sach_san_pham=array();
            foreach ($post['id_san_pham'] as $key => $id_san_pham) {
                $form=$this->getServiceLocator()->get('Application\Form\XuatHangHoaForm');
                $data=array();
                $data['id_khach_hang']=$post['id_khach_hang'];
                $data['id_san_pham']=$id_san_pham;
                $data['so_luong']=round($post['so_luong'][$key], 0, PHP_ROUND_HALF_DOWN);
                $data['gia_nhap']=ceil($post['gia_nhap'][$key]);
                $data['gia_xuat']=ceil($post['gia_xuat'][$key]);
                $san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id_san_pham), array());
                $danh_sach_san_pham[$id_san_pham]=$san_pham[0];
                $co_kiem_tra_so_luong=0;
                if($san_pham[0]['ton_kho']<$data['so_luong']){
                    $co_kiem_tra_so_luong=1;
                }
                else{
                    $danh_sach_san_pham[$id_san_pham]['ton_kho']=$san_pham[0]['ton_kho']-$data['so_luong'];
                }
                               
                $form->setData($data);
                if($form->isValid() and $co_kiem_tra_so_luong==0){
                    // tạo hóa đơn
                    if(!$id_hoa_don){
                        $hoa_don_moi=new HoaDon();
                        $hoa_don_moi->setIdKhachHang($post['id_khach_hang']);
                        $hoa_don_moi->setIdUser($id_user);
                        $date = date('Y-m-d h:i:s a', time());
                        $hoa_don_moi->setNgayXuat($date);
                        $hoa_don_moi->setState(0);
                        $ma_hoa_don=$this->TaoMaTuDong()->taoMaHoaDon();;
                        $hoa_don_moi->setMaHoaDon($ma_hoa_don);
                        $hoa_don_table->saveHoaDon($hoa_don_moi);
                        $hoa_don=$hoa_don_table->getHoaDonByArrayConditionAndArrayColumn(array('ma_hoa_don'=>$ma_hoa_don), array('id_hoa_don'));
                        $id_hoa_don=$hoa_don[0]['id_hoa_don'];
                    }
                    // tạo chi tiết hóa đơn
                    $ct_hoa_don_moi=new CtHoaDon();
                    $ct_hoa_don_moi->exchangeArray($data);
                    $ct_hoa_don_moi->setGia($data['gia_xuat']);
                    $ct_hoa_don_moi->setIdHoaDon($id_hoa_don);
                    $ct_hoa_don_table->saveCtHoaDon($ct_hoa_don_moi);
                }
                else{
                    // xóa dữ liệu hóa đơn
                    if($id_hoa_don){
                        $hoa_don_table->xoaHoaDon(array('id_hoa_don'=>$id_hoa_don));
                    }
                    // chuyển trang thông báo lỗi
                    $this->flashMessenger()->addErrorMessage('Lỗi, không thể xuất hàng hóa!');
                    return $this->redirect()->toRoute('hang_hoa', array('action'=>'xuat-hang-hoa'));
                }
            }            
            // cập nhật lại số lượng trong csdl
            foreach ($danh_sach_san_pham as $key => $san_pham) {
                $san_pham_moi=new SanPham();
                $san_pham_moi->exchangeArray($san_pham);                
                $san_pham_table->saveSanPham($san_pham_moi);
            }
            // xuất hàng hóa thành công
            $this->flashMessenger()->addSuccessMessage('Chúc mừng, xuất hàng hóa thành công!');
            return $this->redirect()->toRoute('ban_hang', array('action'=>'chi-tiet-hoa-don', 'id'=>$id_hoa_don));
        }       
    }

    public function danhSachKhachHangAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $id_kho=$this->AuthService()->getIdKho();
            $khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
            $danh_sach_khach_hang=$khach_hang_table->getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho, 't1.state'=>1), array('id_khach_hang', 'ho_ten', 'di_dong', 'dia_chi'), array('id_kenh_phan_phoi', 'kenh_phan_phoi'));
            $response=array('error'=>'', 'danh_sach_khach_hang'=>$danh_sach_khach_hang);
            $json = new JsonModel($response);
            return $json;
        }
        else {
            $response=array('error'=>'Phương thức nhập không đúng');
            $json = new JsonModel($response);
            return $json;
        }
            
   
    }

    public function danhSachSanPhamXuatAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $post=$request->getPost();
            $id_kenh_phan_phoi=$post['id_kenh_phan_phoi'];
            $id_kho=$this->AuthService()->getIdKho();      
            $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
            $danh_sach_san_pham=$san_pham_table->getSanPhamAndDonViTinhAndGiaXuatByArrayCondition(array('id_kho'=>$id_kho, 'state'=>1, 'id_kenh_phan_phoi'=>$id_kenh_phan_phoi));
            $response=array('error'=>'', 'danh_sach_san_pham'=>$danh_sach_san_pham);
            $json = new JsonModel($response);
            return $json;
        }
        else {
            $response=array('error'=>'Phương thức nhập không đúng');
            $json = new JsonModel($response);
            return $json;
        }
    }

    public function doiTraHangHoaAction(){
        
    }

    public function createDataAction(){
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        for ($i=1000; $i < 2000; $i++) { 
            $san_pham_moi=new SanPham();
            $san_pham_moi->setIdKho(1);
            $san_pham_moi->setIdDonViTinh(1);
            $san_pham_moi->setIdBarcode(1);
            $san_pham_moi->setMaSanPham('masp_'.$i);
            $san_pham_moi->setMaVach(756371377088125+$i);
            $san_pham_moi->setIdLoaiSanPham(1);
            $san_pham_moi->setTenSanPham('Tên sản phẩm '.$i);
            $san_pham_moi->setMoTa('Mô tả '.$i);
            $san_pham_moi->setHinhAnh('hinh_anh_'.$i);
            $san_pham_moi->setNhan('Nhản '.$i);
            $san_pham_moi->setTonKho($i);
            $san_pham_moi->setLoaiGia('Loại giá '.$i);
            $san_pham_moi->setGiaNhap($i);
            $san_pham_moi->setGiaBia($i);
            $san_pham_moi->setChietKhau($i);
            $san_pham_moi->setState(1);
            $san_pham_moi->setUserId(1);
            $san_pham_table->saveSanPham($san_pham_moi);
        }
        die();
    }

    
}

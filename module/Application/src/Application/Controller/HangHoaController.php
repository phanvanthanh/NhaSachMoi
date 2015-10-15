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
            var_dump($request->getPost());
            die();
        }
    }

    public function xuatHangHoaAction(){

    }

    public function doiTraHangHoaAction(){
        
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
            $danh_sach_san_pham=$san_pham_table->getSanPhamAndDonViTinhByArrayConditionAnd2ArrayColumn(array('t1.id_kho'=>$id_kho, 't1.state'=>1), array('id_san_pham', 'ten_san_pham', 'ma_san_pham', 'ma_vach'), array('don_vi_tinh'));
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

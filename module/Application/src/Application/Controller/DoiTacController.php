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
use Application\Model\Entity\KhachHang;
use Application\Model\Entity\NhaCungCap;
use Zend\View\Model\JsonModel;
use Zend\Db\Sql\Expression;

class DoiTacController extends AbstractActionController
{
// khách hàng
    public function indexAction()
    {
    	$id_kho=$this->AuthService()->getIdKho();
        $khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
        $danh_sach_khach_hang=$khach_hang_table->getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho, 't1.state'=>1), array('id_khach_hang', 'ho_ten', 'di_dong', 'dia_chi'), array('kenh_phan_phoi'));
    	return array('danh_sach_khach_hang'=>$danh_sach_khach_hang);
    }

    public function themKhachHangAction(){
    	$form=$this->getServiceLocator()->get('Application\Form\ThemKhachHangForm');
    	$return['form']=$form;
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
    		$form->setData($post);
    		if($form->isValid()){
    			$khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
    			$khach_hang_moi=new KhachHang();
    			$khach_hang_moi->exchangeArray($post);
    			$khach_hang_moi->setState(1);    			
				$date = date('Y-m-d h:i:s a', time());
    			$khach_hang_moi->setNgayDangKy($date);
    			// xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){  
                	$id_kho=$this->AuthService()->getIdKho();                  
                    $path = "./public/img/orther/customer/".$id_kho."/";
                    $pathSave = "/img/orther/customer/".$id_kho."/";
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
                    $pathSave = "/img/default/customer/default.png";
                }
                $khach_hang_moi->setHinhAnh($pathSave);
    			$khach_hang_table->saveKhachHang($khach_hang_moi);
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm khách hàng thành công!');
    			return $this->redirect()->toRoute('doi_tac');
    		}
    		// ngược lại, form not valid
    		else{
    			$return['form']=$form;
    			return $return;
    		}

    	}
    	// ngược lại không post dữ liệu
    	else{
    			return $return;
    	}
    }

    public function suaThongTinKhachHangAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
        $khach_hang=$khach_hang_table->getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn(array('t1.id_khach_hang'=>$id, 't2.id_kho'=>$id_kho, 't1.state'=>1), array(), array('id_kenh_phan_phoi'));
        if(!$khach_hang){
            $this->flashMessenger()->addErrorMessage('Khách hàng không tồn tại');
            return $this->redirect()->toRoute('doi_tac');
        }
        $form=$this->getServiceLocator()->get('Application\Form\SuaThongTinKhachHangForm');
        $form->setData($khach_hang[0]);
        $return =array('form'=>$form, 'id'=>$id);
        $request=$this->getRequest();
        if($request->isPost()){
            $post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if($form->isValid()){
                $data=array_merge($khach_hang[0], $post);
                $khach_hang_moi=new KhachHang();
                $khach_hang_moi->exchangeArray($data);
                if($post['hinh_anh'] and $post['hinh_anh']['error']==0){
                    $image=$post['hinh_anh'];
                    $id_kho=$this->AuthService()->getIdKho();                  
                    $path = "./public/img/orther/customer/".$id_kho."/";
                    $pathSave = "/img/orther/customer/".$id_kho."/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                    $khach_hang_moi->setHinhAnh($pathSave);
                    // nếu hình khác default thì xóa
                    if(trim($khach_hang[0]['hinh_anh'])!='/img/default/customer/default.png'){
                        $path = './public'.$khach_hang[0]['hinh_anh'];
                        array_map("unlink", glob($path));
                    }
                }
                else{
                    $khach_hang_moi->setHinhAnh($khach_hang[0]['hinh_anh']);
                }
                $khach_hang_moi->setNgayDangKy($khach_hang[0]['ngay_dang_ky']);
                $khach_hang_table->saveKhachHang($khach_hang_moi);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, sửa thông tin khách hàng thành công!');
                return $this->redirect()->toRoute('doi_tac');
            }
            else{
                $return['form']=$form;
                return $return;
            }
        }
        else{
            return $return;    
        }
        
    }

    public function xoaThongTinKhachHangAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
        $khach_hang=$khach_hang_table->getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn(array('id_khach_hang'=>$id, 't2.id_kho'=>$id_kho), array(), array());
        if(!$khach_hang){
            $this->flashMessenger()->addErrorMessage('Không tìm thấy khách hàng cần xóa');
            return $this->redirect()->toRoute('doi_tac');
        }
        $khach_hang_moi=new KhachHang();
        $khach_hang_moi->exchangeArray($khach_hang[0]);
        $khach_hang_moi->setState(0);
        $khach_hang_table->saveKhachHang($khach_hang_moi);
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa thông tin khách hàng thành công!');
        return $this->redirect()->toRoute('doi_tac');
    }

    public function congNoKhachHangAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $post=$request->getPost();
            $id_kho=$this->AuthService()->getIdKho();
            $id_khach_hang=$post['id_khach_hang'];
            $khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
            $khach_hang=$khach_hang_table->getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn(array('t1.id_khach_hang'=>$id_khach_hang, 't2.id_kho'=>$id_kho), array('ho_ten'), array('chiet_khau'));
            if(!$khach_hang){
                $response=array('error'=>'Khách hàng không tồn tại');
                $json = new JsonModel($response);
                return $json;
            }
            // lấy dữ liệu bảng công nợ
            $cong_no_khach_hang_table=$this->getServiceLocator()->get('Application\Model\CongNoKhachHangTable');
            $cong_no=$cong_no_khach_hang_table->getCongNoKhachHangByArrayConditionAndArrayColumn(array('id_khach_hang'=>$id_khach_hang), array(new Expression('max(id_cong_no) as id_cong_no')));
            $cong_no=$cong_no_khach_hang_table->getCongNoKhachHangByArrayConditionAndArrayColumn(array('id_cong_no'=>$cong_no[0]['id_cong_no']), array('du_no'));
            $du_no=0;
            if($cong_no){
                $du_no=$cong_no[0]['du_no'];
            }
            // lấy dữ liệu bảng hóa đơn và chi tiết hóa đơn
            $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
            $danh_sach_hoa_don=$hoa_don_table->getHoaDonAndCtHoaDonByArrayConditionAnd2ArrayColumn(array('t1.id_khach_hang'=>$id_khach_hang), array('ma_hoa_don'), array('gia', 'so_luong'));
            $so_hoa_don=count($danh_sach_hoa_don);
            $no_phat_sinh=0;
            if($danh_sach_hoa_don){
                foreach ($danh_sach_hoa_don as $hoa_don) {
                    $thanh_tien=$hoa_don['gia']*$hoa_don['so_luong'];
                    $no_phat_sinh+=$thanh_tien;
                }
            }
            $tong_no=$du_no+$no_phat_sinh;
            $response=array('error'=>'', 'so_hoa_don'=>$so_hoa_don, 'tong_no'=>$tong_no);
            $json = new JsonModel($response);
            return $json;
        }
        else{
            $response=array('error'=>'Phương thức truyền dữ liệu không đúng');
            $json = new JsonModel($response);
            return $json;
            
        }
    }

    public function createDataKhachHangAction(){
    	$khach_hang_table=$this->getServiceLocator()->get('Application\Model\KhachHangTable');
	    for ($i=0; $i < 1000; $i++) { 
	    	$khach_hang_moi=new KhachHang();
	    	$khach_hang_moi->setIdKenhPhanPhoi(1);
	        $khach_hang_moi->setHoTen('Lưu Kim Loan '.$i);
	        $khach_hang_moi->setDiaChi('Trà Cú - Trà Vinh'); 
	        $khach_hang_moi->setEmail('luukimloan'.$i.'@gmail.com'); 
	        $khach_hang_moi->setMoTa('Mô tả');
	        $khach_hang_moi->setDienThoaiCoDinh('01699580585');
	        $khach_hang_moi->setDiDong('01699580585');
	        $khach_hang_moi->setHinhAnh('/img/default/customer/default.png'); 
	        $khach_hang_moi->setState(1);
	        $khach_hang_moi->setNgayDangKy('');
	        $khach_hang_table->saveKhachHang($khach_hang_moi);
	    }
	    die();	    	
    }


// nhà cung cấp
    public function nhaCungCapAction()
    {
    	$id_kho=$this->AuthService()->getIdKho();
        $nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
        $danh_sach_nha_cung_cap=$nha_cung_cap_table->getNhaCungCapByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 't1.state'=>1), array('id_nha_cung_cap', 'ho_ten', 'di_dong', 'dia_chi'));
    	die(var_dump($danh_sach_nha_cung_cap));
        return array('danh_sach_nha_cung_cap'=>$danh_sach_nha_cung_cap);
    }

    public function themNhaCungCapAction(){
    	$form=$this->getServiceLocator()->get('Application\Form\ThemNhaCungCapForm');
    	$return['form']=$form;
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
    		$form->setData($post);
    		if($form->isValid()){
    			$id_kho=$this->AuthService()->getIdKho();   
    			$nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
    			$nha_cung_cap_moi=new NhaCungCap();
    			$nha_cung_cap_moi->exchangeArray($post);
    			$nha_cung_cap_moi->setState(1);    			
				$date = date('Y-m-d h:i:s a', time());
    			$nha_cung_cap_moi->setNgayDangKy($date);
    			// xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){                  	               
                    $path = "./public/img/orther/nhacungcap/".$id_kho."/";
                    $pathSave = "/img/orther/nhacungcap/".$id_kho."/";
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
                    $pathSave = "/img/default/nhacungcap/default.png";
                }
                $nha_cung_cap_moi->setIdKho($id_kho);
                $nha_cung_cap_moi->setHinhAnh($pathSave);
    			$nha_cung_cap_table->saveNhaCungCap($nha_cung_cap_moi);
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm nhà cung cấp thành công!');
    			return $this->redirect()->toRoute('doi_tac', array('action'=>'nha-cung-cap'));
    		}
    		// ngược lại, form not valid
    		else{
    			$return['form']=$form;
    			return $return;
    		}

    	}
    	// ngược lại không post dữ liệu
    	else{
    			return $return;
    	}
    }

    public function suaThongTinNhaCungCapAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();  
        $nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
        $nha_cung_cap=$nha_cung_cap_table->getNhaCungCapByArrayConditionAndArrayColumn(array('id_nha_cung_cap'=>$id, 'id_kho'=>$id_kho, 'state'=>1), array());
        if(!$nha_cung_cap){
            $this->flashMessenger()->addErrorMessage('Nhà cung cấp không tồn tại');
            return $this->redirect()->toRoute('doi_tac', array('action'=>'nha-cung-cap'));
        }
        $form=$this->getServiceLocator()->get('Application\Form\SuaThongTinNhaCungCapForm');
        $form->setData($nha_cung_cap[0]);
        $return=array('id'=>$id, 'form'=>$form);
        $request=$this->getRequest();
        if($request->isPost()){
            $post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if($form->isValid()){
                $data=array_merge($nha_cung_cap[0], $post);

                $nha_cung_cap_moi=new NhaCungCap();
                $nha_cung_cap_moi->exchangeArray($data);
                // xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){                                     
                    $path = "./public/img/orther/nhacungcap/".$id_kho."/";
                    $pathSave = "/img/orther/nhacungcap/".$id_kho."/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                    $nha_cung_cap_moi->setHinhAnh($pathSave);
                    // nếu hình khác default thì xóa
                    if(trim($nha_cung_cap[0]['hinh_anh'])!='/img/default/nhacungcap/default.png'){
                        $path = './public'.$nha_cung_cap[0]['hinh_anh'];
                        array_map("unlink", glob($path));
                    }
                }
                else{
                    $nha_cung_cap_moi->setHinhAnh($nha_cung_cap[0]['hinh_anh']);
                }
                $nha_cung_cap_moi->setNgayDangKy($nha_cung_cap[0]['ngay_dang_ky']);
                $nha_cung_cap_table->saveNhaCungCap($nha_cung_cap_moi);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, sửa thông tin nhà cung cấp thành công!');
                return $this->redirect()->toRoute('doi_tac', array('action'=>'nha-cung-cap'));
            }
            else{
                $return['form']=$form;
                return $return;
            }

        }
        else{
            return $return;
        }
    }

    public function xoaThongTinNhaCungCapAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
        $nha_cung_cap=$nha_cung_cap_table->getNhaCungCapByArrayConditionAndArrayColumn(array('id_nha_cung_cap'=>$id, 'id_kho'=>$id_kho), array());
        if(!$nha_cung_cap){
            $this->flashMessenger()->addErrorMessage('Không tìm thấy nhà cung cấp cần xóa');
            return $this->redirect()->toRoute('doi_tac',array('action'=>'nha-cung-cap'));
        }
        $nha_cung_cap_moi=new NhaCungCap();
        $nha_cung_cap_moi->exchangeArray($nha_cung_cap[0]);
        $nha_cung_cap_moi->setState(0);
        $nha_cung_cap_table->saveNhaCungCap($nha_cung_cap_moi);
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa thông tin khách hàng thành công!');
        return $this->redirect()->toRoute('doi_tac');
    }

    public function congNoNhaCungCapAction(){
        $request=$this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $post=$request->getPost();
            $id_nha_cung_cap=$post['id_nha_cung_cap'];
            $id_kho=$this->AuthService()->getIdKho();  
            $nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
            $nha_cung_cap=$nha_cung_cap_table->getNhaCungCapByArrayConditionAndArrayColumn(array('id_nha_cung_cap'=>$id_nha_cung_cap, 'id_kho'=>$id_kho), array('ho_ten'));
            if(!$nha_cung_cap){
                $response=array('error'=>'Nhà cung cấp không tồn tại');
                $json = new JsonModel($response);
                return $json;
            }

            $cong_no_nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\CongNoNhaCungCapTable');
            $cong_no=$cong_no_nha_cung_cap_table->getCongNoNhaCungCapByArrayConditionAndArrayColumn(array('id_nha_cung_cap'=>$id_nha_cung_cap), array(new Expression('max(id_cong_no) as id_cong_no')));
            $cong_no=$cong_no_nha_cung_cap_table->getCongNoNhaCungCapByArrayConditionAndArrayColumn(array('id_cong_no'=>$cong_no[0]['id_cong_no']), array('du_no'));
            $du_no=0;
            if($cong_no){
                $du_no=$cong_no[0]['du_no'];
            }
            // lấy dữ liệu bảng phiếu nhập và chi tiết phiếu nhập
            $phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\PhieuNhapTable');
            $danh_sach_phieu_nhap=$phieu_nhap_table->getPhieuNhapAndCtPhieuNhapByArrayConditionAnd2ArrayColumn(array('t1.id_nha_cung_cap'=>$id_nha_cung_cap), array('ma_phieu_nhap'), array('gia_nhap', 'so_luong'));
            $so_phieu_nhap=count($danh_sach_phieu_nhap);
            $no_phat_sinh=0;
            if($danh_sach_phieu_nhap){
                foreach ($danh_sach_phieu_nhap as $phieu_nhap) {
                    $thanh_tien=$phieu_nhap['gia_nhap']*$phieu_nhap['so_luong'];
                    $no_phat_sinh+=$thanh_tien;
                }
            }
            $tong_no=$du_no+$no_phat_sinh;
            $response=array('error'=>'', 'so_phieu_nhap'=>$so_phieu_nhap, 'tong_no'=>$tong_no);
            $json = new JsonModel($response);
            return $json;
        }
        else{
            $response=array('error'=>'Phương thức truyền dữ liệu không đúng');
            $json = new JsonModel($response);
            return $json;
        }
            
    }

    public function createDataNhaCungCapAction(){
    	$nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\NhaCungCapTable');
	    for ($i=0; $i < 1000; $i++) { 
	    	$nha_cung_cap_moi=new NhaCungCap();
	    	$nha_cung_cap_moi->setIdKho(1);
	        $nha_cung_cap_moi->setHoTen('Lưu Kim Loan '.$i);
	        $nha_cung_cap_moi->setDiaChi('Trà Cú - Trà Vinh'); 
	        $nha_cung_cap_moi->setEmail('luukimloan'.$i.'@gmail.com'); 
	        $nha_cung_cap_moi->setMoTa('Mô tả');
	        $nha_cung_cap_moi->setDienThoaiCoDinh('01699580585');
	        $nha_cung_cap_moi->setDiDong('01699580585');
	        $nha_cung_cap_moi->setHinhAnh('/img/default/product/default.png'); 
	        $nha_cung_cap_moi->setState(1);
	        $nha_cung_cap_moi->setNgayDangKy('');
	        $nha_cung_cap_table->saveNhaCungCap($nha_cung_cap_moi);
	    }
	    die();	    	
    }
}

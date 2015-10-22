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
use Application\Model\Entity\KenhPhanPhoi;
use Application\Model\Entity\GiaXuat;

class ChinhSachController extends AbstractActionController
{
    public function indexAction()
    {
        $id_kho=$this->AuthService()->getIdKho();
        $kenh_phan_phoi_table=$this->getServiceLocator()->get('Application\Model\KenhPhanPhoiTable');
        $danh_sach_chiet_khau=$kenh_phan_phoi_table->getKenhPhanPhoiByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho), array('id_kenh_phan_phoi', 'kenh_phan_phoi', 'chiet_khau_xuong', 'chiet_khau_len'));
    	
        $form=$this->getServiceLocator()->get('Application\Form\SuaChietKhauForm');
    	return array('danh_sach_chiet_khau'=>$danh_sach_chiet_khau, 'form'=>$form);
    }

    public function suaChietKhauAction(){
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=$request->getPost();
    		$form=$this->getServiceLocator()->get('Application\Form\SuaChietKhauForm');
    		$form->setData($post);
    		if($form->isValid()){
    			$id_kho=$this->AuthService()->getIdKho();
    			$kenh_phan_phoi_table=$this->getServiceLocator()->get('Application\Model\KenhPhanPhoiTable');
                $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
                $gia_xuat_table=$this->getServiceLocator()->get('Application\Model\GiaXuatTable');
    			$chiet_khau=$kenh_phan_phoi_table->getKenhPhanPhoiByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'id_kenh_phan_phoi'=>$post['id_kenh_phan_phoi']), array());
    			if(!$chiet_khau){
    				$this->flashMessenger()->addErrorMessage('Lỗi không tìm thấy kênh cần sửa');
    				return $this->redirect()->toRoute('chinh_sach');
    			}
    			// sửa lại chiết khấu trong bảng kênh phân phối
    			$kenh_phan_phoi_moi=new KenhPhanPhoi();
				$kenh_phan_phoi_moi->exchangeArray($chiet_khau[0]);
				$kenh_phan_phoi_moi->setChietKhauXuong($post['chiet_khau_xuong']);
				$kenh_phan_phoi_moi->setChietKhauLen($post['chiet_khau_len']);
				$kenh_phan_phoi_table->saveKenhPhanPhoi($kenh_phan_phoi_moi);
    			if($post['sua_gia_xuat']==1){
    				// sửa lại tất cả giá xuất của sản phẩm
                    $danh_sach_gia_xuat=$san_pham_table->getAllSanPhamAndGiaXuatByIdKenhPhanPhoiAndIdKho(array('id_kenh_phan_phoi'=>$post['id_kenh_phan_phoi'], 'id_kho'=>$id_kho));
                    foreach ($danh_sach_gia_xuat as $key => $gia_xuat) {
                        if($gia_xuat['loai_gia']==1 and $gia_xuat['gia_bia']>0){
                            $gia_xuat_moi=new GiaXuat();
                            $gia_xuat_moi->exchangeArray($gia_xuat);
                            $gia_xuat_moi->setIdKenhPhanPhoi($post['id_kenh_phan_phoi']);
                            $loi_nhuan=(float)ceil(($gia_xuat['gia_bia']*$post['chiet_khau_xuong'])/100);
                            $gx=(float)$gia_xuat['gia_bia']-(float)$loi_nhuan;
                            $gia_xuat_moi->setGiaXuat($gx);
                            $gia_xuat_table->saveGiaXuat($gia_xuat_moi);
                        }
                        elseif($gia_xuat['loai_gia']==0 and $gia_xuat['gia_nhap']>0) {
                            $gia_xuat_moi=new GiaXuat();
                            $gia_xuat_moi->exchangeArray($gia_xuat);
                            $gia_xuat_moi->setIdKenhPhanPhoi($post['id_kenh_phan_phoi']);
                            $loi_nhuan=(float)ceil(($gia_xuat['gia_nhap']*$post['chiet_khau_len'])/100);
                            $gx=(float)$gia_xuat['gia_nhap']+(float)$loi_nhuan;
                            $gia_xuat_moi->setGiaXuat($gx);
                            $gia_xuat_table->saveGiaXuat($gia_xuat_moi);
                        }
                    }
    			}    			
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật thông tin chiết khấu thành công');
    			return $this->redirect()->toRoute('chinh_sach');
    		}
    		else{ // ngược lại form not valid
    			$this->flashMessenger()->addErrorMessage('Lỗi dữ liệu nhập không đúng');
    			return $this->redirect()->toRoute('chinh_sach');
    		}
    	}
    	else{ // ngược lại không phải post
    		$this->flashMessenger()->addErrorMessage('Lỗi không thực thi');
    		return $this->redirect()->toRoute('chinh_sach');
    	}
    }
}

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

class BanHangController extends AbstractActionController
{
	// doanh thu
    public function indexAction()
    {
        $form=$this->getServiceLocator()->get('Application\Form\LoaiDoanhThuForm');
        $return=array('form'=>$form);
        $request=$this->getRequest();
        if($request->isPost()){

        }
        return $return;
    }

    public function chiTietDoanhThuAction(){

    }

    public function phieuNhapAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\PhieuNhapTable');
        if($id){
            $danh_sach_phieu_nhap=$phieu_nhap_table->getPhieuNhapAndNhaCungCapByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho, 't1.id_nha_cung_cap'=>$id), array(), array('ho_ten'));
        }
        else{
            $danh_sach_phieu_nhap=$phieu_nhap_table->getPhieuNhapAndNhaCungCapByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho), array(), array('ho_ten'));
        }
        return array('danh_sach_phieu_nhap'=>$danh_sach_phieu_nhap);
    }

    public function chiTietPhieuNhapAction(){
        $id=$this->params('id');
        if($id){
            $id_kho=$this->AuthService()->getIdKho();
            $phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\PhieuNhapTable');
            $ct_phieu_nhap=$phieu_nhap_table->getPhieuNhap(array('id_phieu_nhap'=>$id, 'id_kho'=>$id_kho));
            if($ct_phieu_nhap){
                return array('ct_phieu_nhap'=>$ct_phieu_nhap);
            }            
        }
        $this->flashMessenger()->addErrorMessage('Phiếu nhập không tồn tại');
        return $this->redirect()->toRoute('ban_hang');
       
            
    }

    public function hoaDonAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
        if($id){
            $danh_sach_hoa_don=$hoa_don_table->getHoaDonAndUserAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn(array('t2.id_kho'=>$id_kho, 't1.id_khach_hang'=>$id), array(), array(), array('ho_ten'), array('kenh_phan_phoi'));
        }
        else{
            $danh_sach_hoa_don=$hoa_don_table->getHoaDonAndUserAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn(array('t2.id_kho'=>$id_kho), array(), array(), array('ho_ten'), array('kenh_phan_phoi'));
        }        
        return array('danh_sach_hoa_don'=>$danh_sach_hoa_don);
    }

    public function chiTietHoaDonAction(){
    	$id=$this->params('id');
        if($id){
            $id_kho=$this->AuthService()->getIdKho();
            $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
            $ct_hoa_don=$hoa_don_table->getHoaDon(array('id_hoa_don'=>$id, 'id_kho'=>$id_kho));
            if($ct_hoa_don){
                return array('ct_hoa_don'=>$ct_hoa_don);
            }            
        }
        $this->flashMessenger()->addErrorMessage('Hóa đơn không tồn tại');
        return $this->redirect()->toRoute('ban_hang');
    }
}

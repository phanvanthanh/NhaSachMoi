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
        $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
        $kenh_phan_phoi_table=$this->getServiceLocator()->get('Application\Model\KenhPhanPhoiTable');
        $id_kho=$this->AuthService()->getIdKho();
        $return=array('form'=>$form);
        $request=$this->getRequest();
        $loai_doanh_thu='ngay';
        if($request->isPost()){
            $post=$request->getPost();
            $form->setData($post);
            if($form->isValid()){
                $loai_doanh_thu=$post['loai_doanh_thu'];
            }
        }
        $danh_sach_kenh_phan_phoi=$kenh_phan_phoi_table->getKenhPhanPhoiByIdKho($id_kho);
        $tat_ca_doanh_thu=$hoa_don_table->getDoanhThu(array('loai_doanh_thu'=>$loai_doanh_thu, 'id_kho'=>$id_kho));
        $danh_sach_doanh_thu_theo_kenh=array();
        foreach ($danh_sach_kenh_phan_phoi as $key => $value) {
            $danh_sach_doanh_thu_theo_kenh[$key]=$hoa_don_table->getDoanhThu(array('loai_doanh_thu'=>$loai_doanh_thu, 'where'=>$key, 'id_kho'=>$id_kho));
        }
        $return['tat_ca_doanh_thu']=$tat_ca_doanh_thu;
        $return['danh_sach_doanh_thu_theo_kenh']=$danh_sach_doanh_thu_theo_kenh;
        $return['danh_sach_kenh_phan_phoi']=$danh_sach_kenh_phan_phoi;
        return $return;
    }

    public function chiTietDoanhThuAction(){
        $date=$this->params('id');
        $length=strlen($date);        
        if($length==8){
            $date_type='ngay';
            $tam=$date[0].$date[1].'-'.$date[2].$date[3].'-'.$date[4].$date[5].$date[6].$date[7];
            $date=$tam;
        }
        elseif($length==6){
            $date_type='thang';
            $tam=$date[0].$date[1].'-'.$date[2].$date[3].$date[4].$date[5];
            $date=$tam;
        }
        elseif ($length==4) {
            $date_type='nam';
        }
        $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
        $id_kho=$this->AuthService()->getIdKho();
        $danh_sach_chi_tiet_doanh_thu=$hoa_don_table->getChiTietDoanhThu(array('date_type'=>$date_type, 'date_value'=>$date, 'id_kho'=>$id_kho));
        $return=array();
        $return['danh_sach_chi_tiet_doanh_thu']=$danh_sach_chi_tiet_doanh_thu;
        $return['date']=$date;
        return $return;
    }

    public function chiTietDonHangAction(){
        $id=$this->params('id');
        if($id){
            $id_kho=$this->AuthService()->getIdKho();
            $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
            $ct_don_hang=$hoa_don_table->getHoaDon(array('id_hoa_don'=>$id, 'id_kho'=>$id_kho));
            if($ct_don_hang){
                return array('ct_don_hang'=>$ct_don_hang);
            }            
        }
        $this->flashMessenger()->addErrorMessage('Đơn hàng không tồn tại');
        return $this->redirect()->toRoute('ban_hang');
    }

    public function phieuNhapAction(){
        $id=$this->params('id'); // chinh la id_nha_cung_cap
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
        $id=$this->params('id'); // chính là id_khach_hang
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


    public function phieuDoiTraAction(){
        $id=$this->params('id'); // chinh la id_khach_hang       
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_doi_tra_table=$this->getServiceLocator()->get('Application\Model\PhieuDoiTraTable');
        if($id){
            $danh_sach_phieu_doi_tra=$phieu_doi_tra_table->getPhieuDoiTraAndHoaDonAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn(array('t4.id_kho'=>$id_kho, 't3.id_khach_hang'=>$id), array('id_phieu_doi_tra', 'ngay_xuat'), array('ma'=>'ma_hoa_don'), array('ho_ten', 'id_khach_hang'), array());
        }
        else{
            $danh_sach_phieu_doi_tra=$phieu_doi_tra_table->getPhieuDoiTraAndHoaDonAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn(array('t4.id_kho'=>$id_kho), array('id_phieu_doi_tra', 'ngay_xuat'), array('ma'=>'ma_hoa_don'), array('ho_ten', 'id_khach_hang'), array());
        }      
        return array('danh_sach_phieu_doi_tra'=>$danh_sach_phieu_doi_tra);
    }

    public function chiTietPhieuDoiTraAction(){
        $id=$this->params('id'); // chinh la id_khach_hang       
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_doi_tra_table=$this->getServiceLocator()->get('Application\Model\PhieuDoiTraTable');
        $return=array('chi_tiet_phieu_doi_tra'=>'');
        if($id){
            
        }
        return $return;
    }
}

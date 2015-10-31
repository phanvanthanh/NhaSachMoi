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

class ThanhToanController extends AbstractActionController
{
    public function indexAction()
    {
        $id_kho=$this->AuthService()->getIdKho();        
        $phieu_thu_table=$this->getServiceLocator()->get('Application\Model\PhieuThuTable');
        $form=$this->getServiceLocator()->get('Application\Form\TongHopThuChiForm');
        $request=$this->getRequest();
        $return = array('form'=>$form);
        if($request->isPost()){
        	$post=$request->getPost();
        	$form->setData($post);
        	if($form->isValid()){     		

        		$array=explode('/', $post['thoi_gian_bat_dau']);
        		$bat_dau = $array[2].'-'.$array[0].'-'.$array[1];

        		$array=explode('/', $post['thoi_gian_ket_thuc']);
        		$ket_thuc = $array[2].'-'.$array[0].'-'.$array[1];
        		$danh_sach_thu_chi=$phieu_thu_table->tongHopThuChi(array('id_kho'=>$id_kho, 'thoi_gian_bat_dau'=>$bat_dau, 'thoi_gian_ket_thuc'=>$ket_thuc));
        		$return['danh_sach_thu_chi']=$danh_sach_thu_chi;
        		return $return;
        	}
        }
        $danh_sach_thu_chi=$phieu_thu_table->tongHopThuChi(array('id_kho'=>$id_kho));
        $return['danh_sach_thu_chi']=$danh_sach_thu_chi;
        return $return;
    }

    public function thuKhachHangAction(){
    	/*
        $id_kho=$this->AuthService()->getIdKho();
        $cong_no_khach_hang_table=$this->getServiceLocator()->get('Application\Model\CongNoKhachHangTable');
    	$danh_sach_cong_no=$cong_no_khach_hang_table->getCongNo(array('id_kho'=>$id_kho));
    	return array('danh_sach_cong_no'=>$danh_sach_cong_no);
        */
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_thu_table=$this->getServiceLocator()->get('Application\Model\PhieuThuTable');
        $danh_sach_phieu_thu=$phieu_thu_table->getPhieuThuAndUserByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho), array('ma'=>'ma_phieu_thu', 'ly_do', 'so_tien', 'ngay_thanh_toan'), array());
        return array('danh_sach_phieu_thu'=>$danh_sach_phieu_thu);
    }
    public function chiKhachHangAction(){
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_chi_khach_hang_table=$this->getServiceLocator()->get('Application\Model\PhieuChiKhachHangTable');
        $danh_sach_phieu_chi_khach_hang=$phieu_chi_khach_hang_table->getPhieuChiKhachHangAndUserByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho), array('ma'=>'ma_phieu_chi', 'ly_do', 'so_tien', 'ngay_thanh_toan'), array());
        return array('danh_sach_phieu_chi_khach_hang'=>$danh_sach_phieu_chi_khach_hang);
    }

    public function chiNhaCungCapAction(){
        /*
        $id_kho=$this->AuthService()->getIdKho();
        $cong_no_nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\CongNoNhaCungCapTable');
        $danh_sach_cong_no=$cong_no_nha_cung_cap_table->getCongNo(array('id_kho'=>$id_kho));
        return array('danh_sach_cong_no'=>$danh_sach_cong_no);
        */
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_chi_table=$this->getServiceLocator()->get('Application\Model\PhieuChiTable');
        $danh_sach_phieu_chi=$phieu_chi_table->getPhieuChiAndUserByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho), array('ma'=>'ma_phieu_chi', 'ly_do', 'so_tien', 'ngay_thanh_toan'), array());
        return array('danh_sach_phieu_chi'=>$danh_sach_phieu_chi);
    }

    public function lapPhieuThuKhachHangAction(){
        $form=$this->getServiceLocator()->get('Application\Form\LapPhieuThuForm');
        $return=array('form'=>$form);
        return $return;
    }   

    public function lapPhieuChiKhachHangAction(){

    }

    public function lapPhieuChiNhaCungCapAction(){
        $form=$this->getServiceLocator()->get('Application\Form\LapPhieuChiForm');
        $return=array('form'=>$form);
        return $return;
    }
}

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
        		//die(var_dump($bat_dau, $ket_thuc));
        		$danh_sach_thu_chi=$phieu_thu_table->tongHopThuChi(array('thoi_gian_bat_dau'=>$bat_dau, 'thoi_gian_ket_thuc'=>$ket_thuc));
        		$return['danh_sach_thu_chi']=$danh_sach_thu_chi;
        		return $return;
        	}
        }
        $danh_sach_thu_chi=$phieu_thu_table->tongHopThuChi(array());
        $return['danh_sach_thu_chi']=$danh_sach_thu_chi;
        return $return;
    }

    public function khachHangAction(){
    	$cong_no_khach_hang_table=$this->getServiceLocator()->get('Application\Model\CongNoKhachHangTable');
    	$danh_sach_cong_no=$cong_no_khach_hang_table->getCongNo(array());
    	return array('danh_sach_cong_no'=>$danh_sach_cong_no);
    }

    public function nhaCungCapAction(){
        $cong_no_nha_cung_cap_table=$this->getServiceLocator()->get('Application\Model\CongNoNhaCungCapTable');
        $danh_sach_cong_no=$cong_no_nha_cung_cap_table->getCongNo(array());
        return array('danh_sach_cong_no'=>$danh_sach_cong_no);
    }

    public function lapPhieuThuAction(){
        $form=$this->getServiceLocator()->get('Application\Form\LapPhieuThuForm');
        $return=array('form'=>$form);
        return $return;
    }

    public function lapPhieuChiAction(){
       
    }

    public function lapPhieuChiKhachHangAction(){

    }
}

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
        
    }

    public function phieuNhapAction(){
        $id_kho=$this->AuthService()->getIdKho();
        $phieu_nhap_table=$this->getServiceLocator()->get('Application\Model\PhieuNhapTable');
        $danh_sach_phieu_nhap=$phieu_nhap_table->getPhieuNhapAndNhaCungCapByArrayConditionAnd2ArrayColumn(array('t2.id_kho'=>$id_kho), array(), array('ho_ten'));
        return array('danh_sach_phieu_nhap'=>$danh_sach_phieu_nhap);
    }

    public function chiTietPhieuNhapAction(){

    }

    public function hoaDonAction(){
        $id_kho=$this->AuthService()->getIdKho();
        $hoa_don_table=$this->getServiceLocator()->get('Application\Model\HoaDonTable');
        $danh_sach_hoa_don=$hoa_don_table->getHoaDonAndUserAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn(array('t2.id_kho'=>$id_kho), array(), array(), array('ho_ten'), array('kenh_phan_phoi'));
        return array('danh_sach_hoa_don'=>$danh_sach_hoa_don);
    }

    public function chiTietHoaDonAction(){
    	
    }
}

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
        
    }

    public function khachHangAction(){
    	$cong_no_khach_hang_table=$this->getServiceLocator()->get('Application\Model\CongNoKhachHangTable');
    	$danh_sach_cong_no=$cong_no_khach_hang_table->getCongNo(array());
    	return array('danh_sach_cong_no'=>$danh_sach_cong_no);
    	die(var_dump($danh_sach_cong_no));
    }

    public function nhaCungCapAction(){

    }

    public function lapPhieuThuAction(){

    }

    public function lapPhieuChiAction(){

    }
}

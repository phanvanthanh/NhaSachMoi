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

class HangHoaController extends AbstractActionController
{
    public function indexAction()
    {
        
    }

    public function danhSachSanPhamAction(){
    	$return=array();
    	$san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
    	$danh_sach_san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array(), array('ten_san_pham', 'ma_san_pham', 'ton_kho', 'id_loai_san_pham','nhan'));
    	$return['danh_sach_san_pham']=$danh_sach_san_pham;
    	return $return;
    }
}

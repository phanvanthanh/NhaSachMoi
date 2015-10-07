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


class HangHoaController extends AbstractActionController
{
    public function indexAction()
    {
        $return=array();
        $id_kho=$this->AuthService()->getIdKho();       
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        $danh_sach_san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho), array('ten_san_pham', 'ma_san_pham', 'ton_kho', 'loai_san_pham','nhan'));
        $return['danh_sach_san_pham']=$danh_sach_san_pham;
        return $return;
    }

    public function bangGiaAction(){
    	
    }

    public function themSanPhamAction(){
        
    }

    public function createDataAction(){
        
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        for ($i=1000; $i < 2000; $i++) { 
            $san_pham_moi=new SanPham();
            $san_pham_moi->setIdKho(2);
            $san_pham_moi->setIdDonViTinh(1);
            $san_pham_moi->setIdBarcode(1);
            $san_pham_moi->setMaSanPham('masp_'.$i);
            $san_pham_moi->setMaVach(756371377088125+$i);
            $san_pham_moi->setLoaiSanPham('Loại sản phẩm'.$i);
            $san_pham_moi->setTenSanPham('Tên sản phẩm '.$i);
            $san_pham_moi->setMoTa('Mô tả '.$i);
            $san_pham_moi->setHinhAnh('hinh_anh_'.$i);
            $san_pham_moi->setNhan('Nhản '.$i);
            $san_pham_moi->setTonKho($i);
            $san_pham_moi->setLoaiGia('Loại giá '.$i);
            $san_pham_moi->setGiaNhap($i);
            $san_pham_moi->setGiaBia($i);
            $san_pham_moi->setChiecKhau($i);
            $san_pham_table->saveSanPham($san_pham_moi);
        }

        die();
    }
}

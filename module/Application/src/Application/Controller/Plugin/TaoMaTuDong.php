<?php
namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
class TaoMaTuDong extends AbstractPlugin{
    
    public function taoMaPhieuNhap() {
        $thang=date('m');
        $nam=date("Y");
        $thang_nam=$thang.$nam[2].$nam[3].'-';        
        $phieu_nhap_table=$this->getController()->getServiceLocator()->get('Application\Model\PhieuNhapTable');
        $so_phieu_nhap=$phieu_nhap_table->countPhieuNhapByMaPhieuNhap(array('ma_phieu_nhap'=>$thang_nam));
        $so_phieu_nhap=$so_phieu_nhap['num'];
        $so_phieu_nhap++;
        $ma_phieu_nhap='';
        if($so_phieu_nhap<10){        	
        	$ma_phieu_nhap=$thang_nam.'000'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>=10 and $so_phieu_nhap<100) {
        	$ma_phieu_nhap=$thang_nam.'00'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>=100 and $so_phieu_nhap<1000) {
        	$ma_phieu_nhap=$thang_nam.'0'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>=1000 and $so_phieu_nhap<10000) {
        	$ma_phieu_nhap=$thang_nam.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>=10000) {
        	$ma_phieu_nhap=$thang_nam.$so_phieu_nhap;
        }
        return $ma_phieu_nhap;
    }

    public function taoMaHoaDon() {
        $thang=date('m');
        $nam=date("Y");
        $thang_nam=$thang.$nam[2].$nam[3].'-';        
        $hoa_don_table=$this->getController()->getServiceLocator()->get('Application\Model\HoaDonTable');
        $so_hoa_don=$hoa_don_table->countHoaDonByMaHoaDon(array('ma_hoa_don'=>$thang_nam));
        $so_hoa_don=$so_hoa_don['num'];
        $so_hoa_don++;
        $ma_hoa_don='';
        if($so_hoa_don<10){          
            $ma_hoa_don=$thang_nam.'000'.$so_hoa_don;
        }
        elseif ($so_hoa_don>=10 and $so_hoa_don<100) {
            $ma_hoa_don=$thang_nam.'00'.$so_hoa_don;
        }
        elseif ($so_hoa_don>=100 and $so_hoa_don<1000) {
            $ma_hoa_don=$thang_nam.'0'.$so_hoa_don;
        }
        elseif ($so_hoa_don>=1000 and $so_hoa_don<10000) {
            $ma_hoa_don=$thang_nam.$so_hoa_don;
        }
        elseif ($so_hoa_don>=10000) {
            $ma_hoa_don=$thang_nam.$so_hoa_don;
        }
        return $ma_hoa_don;
    }
}
?>
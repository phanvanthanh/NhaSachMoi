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
        $ma_phieu_nhap='';
        if($so_phieu_nhap<10){
        	$so_phieu_nhap++;
        	$ma_phieu_nhap=$thang_nam.'000'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>10 and $so_phieu_nhap<100) {
        	$so_phieu_nhap++;
        	$ma_phieu_nhap=$thang_nam.'00'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>100 and $so_phieu_nhap<1000) {
        	$so_phieu_nhap++;
        	$ma_phieu_nhap=$thang_nam.'0'.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>1000 and $so_phieu_nhap<10000) {
        	$so_phieu_nhap++;
        	$ma_phieu_nhap=$thang_nam.$so_phieu_nhap;
        }
        elseif ($so_phieu_nhap>10000) {
        	$so_phieu_nhap++;
        	$ma_phieu_nhap=$thang_nam.$so_phieu_nhap;
        }
        return $ma_phieu_nhap;
    }
}
?>
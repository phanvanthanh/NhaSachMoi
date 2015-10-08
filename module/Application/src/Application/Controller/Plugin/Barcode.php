<?php
namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
class Barcode extends AbstractPlugin{
    
    public function createBarcode() { 
        $barcode_table=$this->getController()->getServiceLocator()->get('Application\Model\BarcodeTable');
        $san_pham_table=$this->getController()->getServiceLocator()->get('Application\Model\SanPhamTable');
        $read = $this->getController()->getServiceLocator()->get('AuthService')->getStorage()->read();
        $id_kho=$read['id_kho'];
        $barcode=$barcode_table->getBarcodeByArrayConditionAndArrayColumn(array('state'=>1), array('ten_barcode', 'id_barcode'));
        $loaiMV=$barcode[0]['ten_barcode'];
        $maVach=''; $a='';
        $mang=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        if($loaiMV=='Code128')
        {            
            do
            {
                $a='';
                for ($i = 0; $i<15; $i++) 
                {
                    $a .= mt_rand(0,9);
                }
                $maVach=$a;
                $maVachSanPham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$maVach), array('id_san_pham'));
            }
            while($maVachSanPham);
        }

        if($loaiMV=='Codabar')
        {     
            do
            {
                $a='';
                $rand1=$mang[rand(0,25)];
                $rand2=$mang[rand(0,25)];            
                for ($i = 0; $i<13; $i++) 
                {
                    $a .= mt_rand(0,9);
                }        
                $maVach=$rand1.$a.$rand2;
                $maVachSanPham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$maVach), array('id_san_pham'));
            }
            while($maVachSanPham);
        }

        if($loaiMV=='Code25')
        {
            do
            {
                $a='';
                for ($i = 0; $i<15; $i++) 
                {
                    $a .= mt_rand(0,9);
                }        
                $maVach=$a;
                $maVachSanPham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$maVach), array('id_san_pham'));
            }
            while($maVachSanPham);
        }
        if($loaiMV=='Ean13')
        {
            do
            {
                $a='';
                for ($i = 0; $i<12; $i++) 
                {
                    $a .= mt_rand(0,9);
                }        
                $maVach=$a;
                $maVachSanPham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$maVach), array('id_san_pham'));
            }
            while($maVachSanPham);
        }
        if($loaiMV=='Code39')
        {
            do
            {
                $a='';
                for ($i = 0; $i<15; $i++) 
                {
                    $a .= mt_rand(0,9);
                }        
                $maVach=$a;
                $maVachSanPham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$maVach), array('id_san_pham'));
            }
            while($maVachSanPham);
        }
        return array('id_barcode'=>$barcode[0]['id_barcode'], 'ma_vach'=>$maVach);
    }
}
?>
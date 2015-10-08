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
        $danh_sach_san_pham=$san_pham_table->getSanPhamAndLoaiSanPhamByArrayConditionAnd2ArrayColumn(array('t1.id_kho'=>$id_kho), array('ten_san_pham', 'ma_san_pham', 'ton_kho', 'nhan'), array('loai_san_pham'));
        $return['danh_sach_san_pham']=$danh_sach_san_pham;
        return $return;
    }

    public function bangGiaAction(){
    	
    }

    public function themSanPhamAction(){        
        $return=array();
        $form=$this->getServiceLocator()->get('Application\Form\ThemSanPhamForm');
        $return['form']=$form;
        $request=$this->getRequest();
        if($request->isPost()){
            $post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if($form->isValid()){
                $san_pham_moi=new SanPham();
                $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
                $id_kho=$this->AuthService()->getIdKho();
                $san_pham_moi->exchangeArray($post);
                // nếu không nhập mã sản phẩm thì tự động tạo
                if(!$post['ma_san_pham']){
                    $arrays=explode(' ', $post['ten_san_pham']);
                    $ma_san_pham='sp';
                    foreach ($arrays as $value) {
                        $ma_san_pham.=strtolower($value[0]);
                    }
                    $san_pham_moi->setMaSanPham($ma_san_pham);
                }
                // nếu nhập mã vạch
                if($post['ma_vach']){
                    $san_pham_moi->setIdBarcode(6);
                }
                // ngược lại không nhập mã vạch
                else{
                    $barcode=$this->Barcode()->createBarcode(); 
                    $san_pham_moi->setIdBarcode($barcode['id_barcode']);
                    $san_pham_moi->setMaVach($barcode['ma_vach']);
                }
                // nếu loại giá
                if($post['loai_gia']){
                    $san_pham_moi->setGiaNhap(0);
                }
                else{
                    $san_pham_moi->setGiaBia(0);
                    $san_pham_moi->setChietKhau(0);
                }
                // xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){                    
                    $path = "./public/img/orther/product/".$id_kho."/";
                    $pathSave = "/img/orther/product/".$id_kho."/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->checkPatchExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                }
                else{
                    $pathSave = "/img/orther/product/default.png";
                }
                $san_pham_moi->setHinhAnh($pathSave);
                $san_pham_moi->setIdKho($id_kho);
                $san_pham_moi->setTonKho(0);
                $san_pham_table->saveSanPham($san_pham_moi);

                $this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm sản phẩm thành công!');
                return $this->redirect()->toRoute('hang_hoa', array('action'=>'index'));
            }
            else{// form not valid
                $return['form']=$form;
                return $return;
            }
        }
        else{ // not post value
            return $return;
        }
    }

    public function createDataAction(){
        
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        for ($i=1000; $i < 2000; $i++) { 
            $san_pham_moi=new SanPham();
            $san_pham_moi->setIdKho(1);
            $san_pham_moi->setIdDonViTinh(1);
            $san_pham_moi->setIdBarcode(1);
            $san_pham_moi->setMaSanPham('masp_'.$i);
            $san_pham_moi->setMaVach(756371377088125+$i);
            $san_pham_moi->setIdLoaiSanPham(1);
            $san_pham_moi->setTenSanPham('Tên sản phẩm '.$i);
            $san_pham_moi->setMoTa('Mô tả '.$i);
            $san_pham_moi->setHinhAnh('hinh_anh_'.$i);
            $san_pham_moi->setNhan('Nhản '.$i);
            $san_pham_moi->setTonKho($i);
            $san_pham_moi->setLoaiGia('Loại giá '.$i);
            $san_pham_moi->setGiaNhap($i);
            $san_pham_moi->setGiaBia($i);
            $san_pham_moi->setChietKhau($i);
            $san_pham_table->saveSanPham($san_pham_moi);
        }

        die();
    }

    public function checkPatchExist($path, $newName, $typeName)
    {
        if (file_exists($path . $newName . '_' . $typeName)) {
            $newName = md5(uniqid(mt_rand(), true));
            $this->checkPatchExist($path, $newName, $typeName);
        } else {
            return $newName . '_' . $typeName;
        }
    }
}

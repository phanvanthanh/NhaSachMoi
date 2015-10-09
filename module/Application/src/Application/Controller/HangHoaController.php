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
        $danh_sach_san_pham=$san_pham_table->getSanPhamAndLoaiSanPhamByArrayConditionAnd2ArrayColumn(array('t1.id_kho'=>$id_kho), array('id_san_pham', 'ten_san_pham', 'ma_san_pham', 'ton_kho', 'nhan'), array('loai_san_pham'));
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
                
                // nếu nhập mã vạch
                if($post['ma_vach']){
                    // nếu nhập mã vạch thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_vach'=>$post['ma_vach']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_vach')->setMessages(array('Mã vạch này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                    $san_pham_moi->setIdBarcode(6);
                }
                // ngược lại không nhập mã vạch
                else{
                    $barcode=$this->Barcode()->createBarcode(); 
                    $san_pham_moi->setIdBarcode($barcode['id_barcode']);
                    $san_pham_moi->setMaVach($barcode['ma_vach']);
                }
                // nếu nhập mã sản phẩm
                if($post['ma_san_pham']){
                    // nếu nhập mã sản phẩm thì phải kiểm tra có tồn tại chưa
                    $san_pham_ton_tai=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho, 'ma_san_pham'=>$post['ma_san_pham']), array('id_san_pham'));
                    if($san_pham_ton_tai){
                        $form->get('ma_san_pham')->setMessages(array('Mã sản phẩm này đã được sử dụng'));
                        $return['form']=$form;
                        return $return;
                    }
                }
                else{
                    $ma_san_pham=$san_pham_moi->getMaVach();
                    $san_pham_moi->setMaSanPham($ma_san_pham);
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
                    $newName = $this->CheckPatchExist()->checkPatchExist($path, $uniqueToken, $image['name']);
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

    public function suaSanPhamAction(){
        $id=$this->params('id');
        $id_kho=$this->AuthService()->getIdKho();
        $return=array('id'=>$id);
        $san_pham_table=$this->getServiceLocator()->get('Application\Model\SanPhamTable');
        // kiểm tra sản phẩm tồn tại
        $san_pham=$san_pham_table->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id, 'id_kho'=>$id_kho), array());
        if(!$san_pham){
            $this->flashMessenger()->addErrorMessage('Sản phẩm không tồn tại');
            return $this->redirect()->toRoute('hang_hoa');
        }
        //tạo form
        $form=$this->getServiceLocator()->get('Application\Form\SuaSanPhamForm');
        $form->setData($san_pham[0]);
        $return['form']=$form;

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $form->setData($post);
            if($form->isValid()){
                die(var_dump('is valid'));
            }else{
                $return['form']=$form;
                return $return;
            }
        }else{
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

    
}

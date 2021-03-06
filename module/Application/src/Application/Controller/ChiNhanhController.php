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
use Application\Model\Entity\Kho;
use Application\Model\Entity\KenhPhanPhoi;
use Permission\Model\Entity\User;

class ChiNhanhController extends AbstractActionController
{
	protected $authservice;
    public function indexAction()
    {
        $kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
        $danh_sach_kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array(), array());
        return array('danh_sach_kho'=>$danh_sach_kho);
    }

    public function taoChiNhanhAction(){
        $form=$this->getServiceLocator()->get('Application\Form\TaoChiNhanhForm');
        $return=array('form'=>$form);
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $form->setData($post);
            if($form->isValid()){                
                $kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
                $kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array('dia_chi_kho'=>$post['dia_chi_kho']), array('id_kho'));
                if($kho){
                    $this->flashMessenger()->addErrorMessage('Địa chỉ kho đã tồn tại');
                    return $this->redirect()->toRoute('chi_nhanh');
                }
                $kho_moi=new Kho();
                $kho_moi->exchangeArray($post);
                $kho_table->saveKho($kho_moi);
                $id_kho_moi=$kho_table->getKhoByArrayConditionAndArrayColumn(array('dia_chi_kho'=>$post['dia_chi_kho']), array('id_kho'));
                $id_kho_moi=$id_kho_moi[0]['id_kho'];
                // tạo kênh phân phối
                $id_kho=$this->AuthService()->getIdKho();
                $kenh_phan_phoi_table=$this->getServiceLocator()->get('Application\Model\KenhPhanPhoiTable');
                $danh_sach_kenh_phan_phoi=$kenh_phan_phoi_table->getKenhPhanPhoiByIdKho($id_kho);
                foreach ($danh_sach_kenh_phan_phoi as $key => $value) {
                	$kenh_phan_phoi_moi=new KenhPhanPhoi();
                	$kenh_phan_phoi_moi->setIdKho($id_kho_moi);
                	$kenh_phan_phoi_moi->setKenhPhanPhoi($value);
                	$kenh_phan_phoi_moi->setChietKhauXuong(0);
                	$kenh_phan_phoi_moi->setChietKhauLen(0);
                	$kenh_phan_phoi_table->saveKenhPhanPhoi($kenh_phan_phoi_moi);
                }
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, tạo chi nhánh mới thành công');
                return $this->redirect()->toRoute('chi_nhanh');
            }
            else{
                $return['form']=$form;
                return $return;
            }  
        }
        else{
            return $return;
        }
            
    }

    public function suaChiNhanhAction(){
        $id=$this->params('id');
        $kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
        $kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array('id_kho'=>$id), array());
        if(!$kho){
            $this->flashMessenger()->addErrorMessage('Không tìm thấy chi nhánh cần sửa');
            return $this->redirect()->toRoute('chi_nhanh');
        }
        $form=$this->getServiceLocator()->get('Application\Form\SuaChiNhanhForm');
        $form->setData($kho[0]);
        $return=array('form'=>$form, 'id'=>$id);
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $form->setData($post);
            if($form->isValid()){
                $kho_ton_tai=$kho_table->getKhoByArrayConditionAndArrayColumn(array('dia_chi_kho'=>$post['dia_chi_kho']), array('id_kho'));
                // nếu địa chỉ mới sửa chưa được sủ dụng, hoặc địa chỉ đó thuộc về kho cần sửa
                if(!$kho_ton_tai or ($kho_ton_tai and $kho_ton_tai[0]['id_kho']==$id)){
                    $kho_moi=new Kho();
                    $kho_moi->exchangeArray($post);
                    $kho_moi->setIdKho($id);
                    $kho_table->saveKho($kho_moi);
                    $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật chi nhánh mới thành công');
                    return $this->redirect()->toRoute('chi_nhanh');
                }
                else{
                    $this->flashMessenger()->addErrorMessage('Địa chỉ này đã tồn tại một chi nhánh khác');
                    return $this->redirect()->toRoute('chi_nhanh');
                }
            }
            else{
                die(var_dump($form->getMessages()));
                $return['form']=$form;
                return $return;
            }
        }
        else{
            return $return;
        }
    }

    public function xoaChiNhanhAction(){
        $id=$this->params('id');
        $kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
        if($id){
            $kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array('id_kho'=>$id), array('ten_kho'));
            if($kho){
                $kho_table->deleteKho(array('id_kho'=>$id));
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa chi nhánh mới thành công');
                return $this->redirect()->toRoute('chi_nhanh');
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi không tìm thấy chi nhánh cần xóa');
        return $this->redirect()->toRoute('chi_nhanh');
    }

    public function quanLyChiNhanhAction(){
    	$id=$this->params('id');
    	$kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
    	if($id){
    		$kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array('id_kho'=>$id), array('ten_kho'));
    		if($kho){
    			$user_id=$this->AuthService()->getUserId();
    			$user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
    			$user=$user_table->getUserByArrayConditionAndArrayColumn(array('user_id'=>$user_id), array());
    			// $user_moi=new User();
    			// $user_moi->exchangeArray($user[0]);
    			// $user_moi->setIdKho($id);
    			// $user_table->saveUser($user_moi);

    			$session=$this->getAuthService()->getStorage()->read();
    			$session['id_kho']=$id;
    			$this->getAuthService()->getStorage()->write($session);
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, chuyển kho thành công! hiện tại bạn đang quản lý kho '.$kho[0]['ten_kho']);
    			return $this->redirect()->toRoute('chi_nhanh');
    		}
    		else{
    			$this->flashMessenger()->addErrorMessage('Lỗi chi nhánh không tồn tại');
    			return $this->redirect()->toRoute('chi_nhanh');
    		}
    	}
    	else{
    		$this->flashMessenger()->addErrorMessage('Lỗi không thể thực thi');
    		return $this->redirect()->toRoute('chi_nhanh');
    	}
    }

    

    public function getAuthService()
    {
        if (! $this->authservice) {
            $authService = $this->getServiceLocator()->get('AuthService');
            $this->authservice = $authService;
        }
        return $this->authservice;
    }
}

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
use Zend\Db\Sql\Expression;
use Permission\Model\Entity\User;

class TaiKhoanController extends AbstractActionController
{
    public function indexAction()
    {
        $user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
        $all_user=$user_table->getAllUser();
        $return=array('all_user'=>$all_user);
        return $return;    	
    }

    public function taoTaiKhoanAction(){
    	$form=$this->getServiceLocator()->get('Application\Form\TaoTaiKhoanForm');
    	$return=array('form'=>$form);
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
    		$form->setData($post);
    		if($form->isValid()){
    			$user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
    			$user_exist=$user_table->getUserByArrayConditionAndArrayColumn(array('username'=>$post['username']), array('user_id'));
    			if($user_exist){
    				$form->get('username')->setMessages(array('Tên đăng nhập này đã tồn tại!'));
    				$return['form']=$form;
    				return $return;
    			}
    			$user_moi=new User();
    			$user_moi->exchangeArray($post);
    			// xử lý hình ảnh
                $image=$post['hinh_anh'];
                if($image and $image['error']==0){  
                	$id_kho=$this->AuthService()->getIdKho();                  
                    $path = "./public/img/orther/user/";
                    $pathSave = "/img/orther/user/";
                    if (! file_exists($path)) {
                        mkdir($path, 0700, true);
                    }
                    $uniqueToken = md5(uniqid(mt_rand(), true));
                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
                    $filter = new \Zend\Filter\File\Rename($path . $newName);
                    $filter->filter($image);
                    $pathSave.=$newName;
                }
                else{
                    $pathSave = "/img/default/user/default.png";
                }
                $user_moi->setHinhAnh($pathSave);
                $user_moi->setState(1);
                $password=md5($post['password']);
                $user_moi->setPassword($password);
    			$user_table->saveUser($user_moi);
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm tài khoản thành công!');
    			return $this->redirect()->toRoute('tai_khoan');
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

    public function suaTaiKhoanAction(){
    	$id=$this->params('id');
    	$user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
    	$user=$user_table->getUserByArrayConditionAndArrayColumn(array('user_id'=>$id, 'state'=>1), array());
    	if(!$user){
    		$this->flashMessenger()->addErrorMessage('Tài khoản không tồn tại');
    		return $this->redirect()->toRoute('tai_khoan');
    	}
    	$form=$this->getServiceLocator()->get('Application\Form\SuaTaiKhoanForm');
    	$form->setData($user[0]);
    	$return=array('form'=>$form, 'id'=>$id, 'hinh_anh'=>$user[0]['hinh_anh']);
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
    		$form->setData($post);
    		if($form->isValid()){
    			$user_exist=$user_table->getUserByArrayConditionAndArrayColumn(array('username'=>$post['username']), array('user_id'));
    			if(!$user_exist or ($user_exist and $user_exist[0]['user_id']==$id)){
    				$user_moi=new User();
	    			$user_moi->exchangeArray($post);
	    			$user_moi->setUserId($id);
	    			// xử lý hình ảnh
	                $image=$post['hinh_anh'];
	                if($image and $image['error']==0){  
	                	$id_kho=$this->AuthService()->getIdKho();                  
	                    $path = "./public/img/orther/user/";
	                    $pathSave = "/img/orther/user/";
	                    if (! file_exists($path)) {
	                        mkdir($path, 0700, true);
	                    }
	                    $uniqueToken = md5(uniqid(mt_rand(), true));
	                    $newName = $this->CheckPathExist()->checkPathExist($path, $uniqueToken, $image['name']);
	                    $filter = new \Zend\Filter\File\Rename($path . $newName);
	                    $filter->filter($image);
	                    $pathSave.=$newName;
	                    $user_moi->setHinhAnh($pathSave);
	                    if($user[0]['hinh_anh']!='/img/default/user/default.png'){
	                    	$path = './public'.$user[0]['hinh_anh'];
                        	array_map("unlink", glob($path));
	                    }
	                }	                
	                $user_moi->setState(1);
	                if($post['password']){
		                $password=md5($post['password']);
		                $user_moi->setPassword($password);
		            }
		            else{
		            	$user_moi->setPassword($user[0]['password']);
		            }
	    			$user_table->saveUser($user_moi);
	    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật tài khoản thành công!');
    				return $this->redirect()->toRoute('tai_khoan');

    			}
    			else{ // ngược lại username đã tồn tại
    				$form->get('username')->setMessages(array('Tên đăng nhập này đã tồn tại!'));
    				$return['form']=$form;
    				return $return;
    			}
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

    public function xoaTaiKhoanAction(){
    	$id=$this->params('id');
    	$user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
    	$user=$user_table->getUserByArrayConditionAndArrayColumn(array('user_id'=>$id, 'state'=>1), array());
    	if(!$user){
    		$this->flashMessenger()->addErrorMessage('Tài khoản không tồn tại');
    		return $this->redirect()->toRoute('tai_khoan');
    	}
    	else{
    		$user_moi=new User();
	    	$user_moi->exchangeArray($user[0]);
	    	$user_moi->setState(0);
	    	$user_table->saveUser($user_moi);
			$this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa tài khoản thành công!');
			return $this->redirect()->toRoute('tai_khoan');
    	}
    }
}

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

    public function quanLyChiNhanhAction(){
    	$id=$this->params('id');
    	$kho_table=$this->getServiceLocator()->get('Application\Model\KhoTable');
    	if($id){
    		$kho=$kho_table->getKhoByArrayConditionAndArrayColumn(array('id_kho'=>$id), array('ten_kho'));
    		if($kho){
    			$user_id=$this->AuthService()->getUserId();
    			$user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
    			$user=$user_table->getUserByArrayConditionAndArrayColumn(array('user_id'=>$user_id), array());
    			$user_moi=new User();
    			$user_moi->exchangeArray($user[0]);
    			$user_moi->setIdKho($id);
    			$user_table->saveUser($user_moi);

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

    public function suaChiNhanhAction(){

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

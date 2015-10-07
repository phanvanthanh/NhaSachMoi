<?php
namespace Permission\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
class AuthService extends AbstractPlugin{
	
    protected $authservice;
    protected $id_kho;
    protected $user_id;

    public function getAuthService() {          
        if (! $this->authservice) {
            $authService = $this->getController()->getServiceLocator()->get('AuthService');
            $this->authservice = $authService;
        }
        return $this->authservice;
    } 

    public function getIdKho() {          
        if (! $this->id_kho) {
            $read = $this->getController()->getServiceLocator()->get('AuthService')->getStorage()->read();
            $this->id_kho = $read['id_kho'];
        }
        return $this->id_kho;
    } 
    public function getUserId() {          
        if (! $this->user_id) {
            $read = $this->getController()->getServiceLocator()->get('AuthService')->getStorage()->read();
            $this->user_id = $read['user_id'];
        }
        return $this->user_id;
    }  
}
?>
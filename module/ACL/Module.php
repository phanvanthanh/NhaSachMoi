<?php
namespace ACL;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ACL\Utility\Acl;

class Module
{

    public function getConfig()
    {
        return array();
    }

    public function onBootstrap(MvcEvent $e)
    { 
        // Phân quyền ACL
        $eventManager = $e->getApplication()->getEventManager();        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 100);
    }

    function boforeDispatch(MvcEvent $event)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $sm = $event->getApplication()->getServiceManager();
        $auth = $sm->get('AuthService');
        $read=$sm->get("AuthService")->getStorage()->read();
        // nếu chưa có white_list
        if(!isset($read['white_list']) and (!$auth->hasIdentity() || !isset($read['user_id']))){
            // lấy white_list chưa đăng nhập
            $jos_admin_resource_table=$sm->get('Permission\Model\JosAdminResourceTable');
            $white_list=$jos_admin_resource_table->getResourceByWhiteList(1);
            $sm->get("AuthService")->getStorage()->write(array('white_list' => $white_list));
            // nếu chưa đăng nhập thì chỉ được vào trang đăng nhập
            $response = $event->getResponse();
            $response->getHeaders()
                ->addHeaderLine('Location', $event->getRouter()
                ->assemble(array(
                'action' => 'login'
            ), array(
                'name' => 'permission/permission'
            )));
            $response->setStatusCode(302);
            return $response;
        }        
        $read=$sm->get("AuthService")->getStorage()->read();
        $white_lists=$read['white_list'];       
        // url cần chuyển tới
        $params=$event->getRouteMatch()->getParams();
        $controller=$params['controller'];
        $action=$this->fixRoute($params['action']);
        

        // duyệt qua white_list nếu không nằm trong white list thì không có quyền
        $is_white_list=0;
        foreach ($white_lists as $key => $white_list) {            
            if($white_list['controller']==$controller and $white_list['action']==$action){
                $is_white_list=1;
                break;            
            }
        }                
        if($is_white_list==0){
            if((!$auth->hasIdentity() || !isset($read['user_id']))){
                // nếu chưa đăng nhập thì chỉ được vào trang đăng nhập
                $response = $event->getResponse();
                $response->getHeaders()
                    ->addHeaderLine('Location', $event->getRouter()
                    ->assemble(array(
                    'action' => 'login'
                ), array(
                    'name' => 'permission/permission'
                )));
                $response->setStatusCode(302);
                return $response;
            }
            die('Xin loi, Duong dan khong hop le. Vui long kiem tra lai!');
        }         
    }

    // sử dụng trong hàm boforeDispatch
    public function fixRoute($action){
        $arrays = explode("-", $action);
        $route=$arrays[0]; unset($arrays[0]);
        foreach ($arrays as $array) {
            $first=strtoupper($array[0]);
            $array[0]=$first;
            $route.=$array;
        }
        return $route;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}
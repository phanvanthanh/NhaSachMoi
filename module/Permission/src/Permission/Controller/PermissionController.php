<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Permission\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Permission\Model\Entity\JosAdminResource;
use Permission\Model\Entity\JosAdminRule;
use Permission\Model\Entity\JosAdminRole;
use Permission\Form\EditPermissionForm;
use Permission\Form\EditResourceForm;
use Permission\Form\EditPermissionOfUserForm;
use Zend\Db\Sql\Expression;
use Permission\Model\MyAuthStorage;

class PermissionController extends AbstractActionController
{
    protected $authservice;
    
    public function indexAction()
    {        
        $return_array =array();
        // danh sách resources        
        $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
        $resources=$resource_table->getResourceByArrayConditionAndArrayColumn(array('is_hidden'=>0), array('resource_id', 'resource', 'resource_name', 'parent_id', 'resource_type'));
        // sử dụng plugin
        $plugin_tree=$this->TreePlugin();
        $resources=$plugin_tree->outputTree($resources, 0);
        // get danh sách quyền
        $jos_admin_role_table = $this->getServiceLocator()->get('Permission\Model\JosAdminRoleTable');
        $roles=$jos_admin_role_table->getRoleByArrayConditionAndArrayColumn(); 
        // edit permission form
        $edit_permission_form=new EditPermissionForm($roles, $resources, $this->getServiceLocator());
        // kiểm tra post dữ liệu
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();            
            $edit_permission_form->setData($post);
            // kiểm tra form nếu hợp lệ
            if($edit_permission_form->isValid()){
                // lấy role_id đã post
                $role_id=$post['role_id']; unset($post['role_id']);
                // kiểm tra role id có tồn tại không
                $roles_exist=$jos_admin_role_table->getRoleByArrayConditionAndArrayColumn(array('role_id'=>$role_id), array('role_name')); 
                if($roles_exist){
                    $jos_admin_rule_table = $this->getServiceLocator()->get('Permission\Model\JosAdminRuleTable');
                    $jos_admin_rule_table->deleteRuleByRoleId($role_id);
                    foreach ($post as $key => $p) {
                        if($p){
                            // lưu quyền truy cập module vào bảng rule, để khi chọn lại rule này thì checkbox bằng true
                            $rule=new JosAdminRule();
                            $rule->setRoleId($role_id);
                            $rule->setResourceId($p);
                            $jos_admin_rule_table->saveResource( $rule);                            
                        }
                    }
                    $this->flashMessenger()->addSuccessMessage('Chúc mừng, Cập nhật quyền thành công.');               
                    return $this->redirect()->toRoute('permission/permission', array('index'));
                } 
                // Lỗi, role id không tồn tại
                $this->flashMessenger()->addErrorMessage('Thông báo, Role không tồn tại. Vui lòng kiểm tra lại!');               
                return $this->redirect()->toRoute('permission/permission', array('index'));
            }
        }
        $return_array['resources']=$resources;
        $return_array['edit_permission_form']=$edit_permission_form;        

        return $return_array;
    }

    public function permissionOfUserAction(){
        $this->layout('layout/ajax_layout');
        $return_array =array();         
        $request=$this->getRequest();
        if($request->isXmlHttpRequest()) // kiểm tra nếu post dữ liệu
        {
            $post=$request->getPost(); //nhận dữ liệu post
            if(!isset($post['role_id']) || !$post['role_id']){                
                // dữ liệu post bằng null
                die('2');
            }
            $role_id=$post['role_id'];
            // danh sách resources theo role_id nếu tồn tại rule id thì checked    
            $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
            $resources=$resource_table->getResourceByRoleId($role_id, array('resource_id', 'resource', 'resource_name', 'parent_id'));
            // sử dụng plugin
            $plugin_tree=$this->TreePlugin();
            $resources=$plugin_tree->outputTree($resources, 0);
            // edit permission form
            $edit_permission_of_user_form=new EditPermissionOfUserForm($resources, $this->getServiceLocator());

            $return_array['resources']=$resources;
            $return_array['edit_permission_of_user_form']=$edit_permission_of_user_form;
            return $return_array;
        }
        // lỗi không post dữ liệu
        die('1');
    }

    public function editAction(){
        $edit_resource_form=new EditResourceForm();
        // danh sách resources        
        $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
        $resources=$resource_table->getResourceByArrayConditionAndArrayColumn(array('is_hidden'=>0), array('resource_id', 'resource', 'resource_name', 'parent_id', 'is_white_list'));
        $plugin_tree=$this->TreePlugin();
        $resources=$plugin_tree->outputTree($resources, 0);
        // return array
        $return_array=array();
        $return_array['edit_resource_form']=$edit_resource_form;
        $return_array['resources']=$resources;
        // post
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            // set form
            $edit_resource_form->setData($post);
            // kiểm tra nếu form hợp lệ
            if($edit_resource_form->isValid()){
                // kiểm tra resource id vừa nhập có tồn tại trong csdl và có phải là Module không
                $resource=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_id'=>$post['resource_id']), array());
                // nếu tồn tại thì tiến hành sửa lại tên
                if($resource){
                    $new_resource=new JosAdminResource();
                    $new_resource->exchangeArray($resource[0]);
                    $new_resource->setResourceName($post['resource_name']);
                    $resource_table->saveResource($new_resource);
                    // thông báo lưu thành công
                    $this->flashMessenger()->addSuccessMessage('Thông báo, cập nhật thành công!');
                    return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
                }
                // ngược lại không tồn tại hoặc không phải module
                else{
                    // thông báo không tìm thấy resource cần sửa
                    $this->flashMessenger()->addErrorMessage('Thông báo, không tìm thấy resource cần sửa. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
                }                
            }
            // ngược lại, nếu form không hợp lệ
            else{
                $return_array['edit_resource_form']=$edit_resource_form;
            }
        }       
        return $return_array;
    }

    public function changeWhiteListAction(){
        $resource_id=$this->params('id');
        if($resource_id){
            $resource_id=$this->params('id');                    
            $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
            $resource=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_id'=>$resource_id));
            if($resource){
                $new_resource=new JosAdminResource();
                $new_resource->exchangeArray($resource[0]);
                $new_resource->setIsWhiteList(0);
                if($resource[0]['is_white_list']==0){
                    $new_resource->setIsWhiteList(1);
                }
                $resource_table->saveResource($new_resource);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, sửa white list thành công!');
                return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
            }
        }
        $this->flashMessenger()->addErrorMessage('Thông báo, lỗi. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
    }

    public function updateAction(){        

        //Auto Save All Controller and Action
        //truy cập tablegateway resource
        $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
        
        //Lấy danh sách module
        $manager= $this->getServiceLocator()->get('ModuleManager');
        $modules= $manager->getLoadedModules();
        $loaded_modules=array();
        $valmodule = array_keys($modules);

        //Xác định action bỏ qua
        $skip_actions_list    = array('notFoundAction', 'getMethodFromAction'); 
        foreach ($valmodule as $loaded_module){            
            $module_class = '\\' .$loaded_module . '\Module';
            $module_object = new $module_class;
            //truy cập phần cấu hình getConfig của từng module
            $config = $module_object->getConfig();
            //Lấy ra danh sách controller
            if (isset($config['controllers'])){
                $controllers = $config['controllers']['invokables'];
                foreach ($controllers as $key => $module_class) {                    
                    //Trả về danh sách các hàm trong class controller, bao gồm cả các hàm kế thừa
                    $tmp_array = get_class_methods($module_class);                    
                    //Lấy ra danh sách các hàm là action
                    foreach ($tmp_array as $action) {
                        if (substr($action, strlen($action)-6) === 'Action' && !in_array($action, $skip_actions_list)) {
                            //Chèn tên action vào mảng action controller
                            $array_modules[$loaded_module][$key][]=substr($action,0,(strlen($action)-6));
                        }
                    }
                }           
            }            
        } 

        // lưu lại những id đã sử dụng, để kiểm tra những id không sử dụng để xóa bỏ
        $array_id_used=array();
        $array_action_is_white_list=array(); 
        foreach ($array_modules as $key => $array_module) {            
            // kiểm tra tên module có tồn tại trong csdl chưa
            $module=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Module', 'resource'=>$key, 'resource_object'=>'ACL'),array('resource_id'));
            // nếu chưa có thì lưu mới module
            if(!$module){
                $jos_admin_resource = new JosAdminResource();
                $jos_admin_resource -> setParentId(0);
                $jos_admin_resource -> setResource($key);
                $jos_admin_resource -> setResourceName($key.' Module');
                $jos_admin_resource -> setResourceType('Module');
                $jos_admin_resource -> setResourceObject('ACL');
                $jos_admin_resource -> setIsWhiteList(0);
                $jos_admin_resource -> setIsHidden(0);
                $resource_table->saveResource($jos_admin_resource);
                // đảm bảo module đã tồn tại trong csdl rồi
                $module=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Module', 'resource'=>$key, 'resource_object'=>'ACL'),array('resource_id'));
            }
            $module_id=$module[0]['resource_id'];
            // id này đã được sử dụng
            $array_id_used[]=$module_id;
            // luu controller  
            $array_controllers=$array_module;
            foreach ($array_controllers as $ctrl_key => $array_controller) {
                // get id controller
                $controller=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Controller', 'resource'=>$ctrl_key, 'resource_object'=>'ACL', 'parent_id'=>$module_id), array('resource_id'));                
                // nếu chưa có controller
                if(!$controller){
                    $jos_admin_resource = new JosAdminResource();
                    $jos_admin_resource -> setParentId($module_id);
                    $jos_admin_resource -> setResource($ctrl_key);
                    $jos_admin_resource -> setResourceName($ctrl_key.' Controller');
                    $jos_admin_resource -> setResourceType('Controller');
                    $jos_admin_resource -> setResourceObject('ACL');
                    $jos_admin_resource -> setIsWhiteList(0);
                    $jos_admin_resource -> setIsHidden(0);
                    $resource_table->saveResource($jos_admin_resource);
                    // đảm bảo lấy được id controller
                    $controller=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Controller', 'resource'=>$ctrl_key, 'resource_object'=>'ACL', 'parent_id'=>$module_id), array('resource_id')); 
                }
                
                $controller_id=$controller[0]['resource_id'];
                // id này đã được sử dụng
                $array_id_used[]=$controller_id;
                $array_actions=$array_controller;
                foreach ($array_actions as $array_action) {
                    $action=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource'=>$array_action, 'parent_id'=>$controller_id, 'resource_type'=>'Action', 'resource_object'=>'ACL'), array('resource_id'));
                    if(!$action){
                        $jos_admin_resource = new JosAdminResource();
                        $jos_admin_resource -> setParentId($controller_id);
                        $jos_admin_resource -> setResource($array_action);
                        $jos_admin_resource -> setResourceName($array_action.' Action');
                        $jos_admin_resource -> setResourceType('Action');
                        $jos_admin_resource -> setResourceObject('ACL');
                        $jos_admin_resource -> setIsWhiteList(0);   
                        $jos_admin_resource -> setIsHidden(0);       
                        $resource_table->saveResource($jos_admin_resource);
                        $action=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource'=>$array_action, 'parent_id'=>$controller_id, 'resource_type'=>'Action', 'resource_object'=>'ACL'), array('resource_id'));
                    }

                    if($action){
                        // id này đã được sử dụng
                        $array_id_used[]=$action[0]['resource_id'];
                    }
                }
            }
        }

        $array_id_not_used=$resource_table->getAllResourceIdUnexistResourceIdInArray($array_id_used);
        if($array_id_not_used){
            $resource_table->deleteResourceByResourceId($array_id_not_used);
        }
        return $this->redirect()->toRoute('permission/permission');
        
    }

    public function loginAction()
    {              
        $this->layout('layout/layout_default'); 
        // kiểm tra nếu đã đăng nhập rồi thì không cho zô
        $read=$this->getAuthService()->getStorage()->read();
        if(isset($read['username']) and $read['username']){
            return $this->redirect()->toRoute('home');
        }
        // tạo form login
        $login_form = $this->getServiceLocator()->get('Permission\Form\LoginForm');
        $return_array=array();
        $return_array['login_form']=$login_form; 
        // tạo url mặc định     
        $url_login='/';
        $return_array['url_login']=$url_login;
        // Kiểm tra có phải request POST
        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            // lấy địa chỉ mặc định để quay lại
            if(isset($post['url'])){
                $url_login=$post['url'];
                $return_array['url_login']=$post['url'];
            }
            $login_form->setData($post);

            if($login_form->isValid()){
                $username=$post['username'];
                $password=$post['password'];                                  
                // Xác định lớp chứng thực authentication
                $this->getAuthService()->getAdapter()->setIdentity($username)->setCredential($password);
                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    $storage = new MyAuthStorage();
                    $storage->forgetMe();
                    $jos_admin_resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
                    $user_table=$this->getServiceLocator()->get('Permission\Model\UserTable');
                    $user=$user_table->getUserByArrayConditionAndArrayColumn(array('username'=>$username), array('user_id'));
                    $user_id=$user[0]['user_id'];
                    $white_list=$jos_admin_resource_table->getResourceByUsername($username);
                    $this->getAuthService()->getStorage()->write(array('username'=>$username, 'user_id'=>$user_id,'white_list' => $white_list));         
                    
                    // thông báo đăng nhập thành công
                    $this->flashMessenger()->addSuccessMessage('Đăng nhập thành công!');
                    return $this->redirect()->toUrl($url_login);
                }
            }                
        }
        $return_array['login_form']=$login_form;
        return $return_array;
    }

    public function logoutAction(){
        $this->layout('layout/layout_default'); 
        $this->getAuthService()->getStorage()->write(array(''));
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toRoute('permission/permission', array('action'=>'login'));
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

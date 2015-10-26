<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\JosAdminRole;

class JosAdminRoleTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Permission/Controller/Permission indexAction
        sử dụng trong Permission/Controller/Permission updateAction
    */
    public function getRoleByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_admin_role'));
        if($array_columns){
            $sqlSelect->columns($array_columns);
        }
        if($array_conditions){
            $sqlSelect->where($array_conditions);
        }
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    /*
        sử dụng trong Application\Factory\Form\TaoTaiKhoanFormFactory
    */
    public function getRole(){      
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_admin_role'));        
        $sqlSelect->columns(array('role_id', 'role_name'));       
        $sqlSelect->where('role_name!="admin"');
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['role_id']] = $resultSet['role_name'];
        }
        return $allRow;
    }

    /*
        sử dụng trong Permission/Controller/Permission updateAction
    */
    public function saveRole(JosAdminRole $role)
    {
        $data = array(
            'role_name' => $role->getRoleName()
        );
        
        $role_id = (int) $role->getRoleId();
        if ($role_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRoleByArrayConditionAndArrayColumn(array('role_id'=>$role_id), array())) {
                $this->tableGateway->update($data, array(
                    'role_id' => $role_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    

   	
}
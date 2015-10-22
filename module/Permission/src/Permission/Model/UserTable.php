<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\User;

class UserTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getUserByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'user'));
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

    public function saveUser(User $user)
    {
        $data = array(
            'role_id'               => $user->getRoleId(),
            'id_kho'                => $user->getIdKho(),
            'username'              => $user->getUsername(),
            'email'                 => $user->getEmail(),
            'display_name'          => $user->getDisplayName(),
            'password'              => $user->getPassword(),
            'ho_ten'                => $user->getHoTen(),
            'dia_chi'               => $user->getDiaChi(),
            'mo_ta'                 => $user->getMoTa(),
            'dien_thoai_co_dinh'    => $user->getDienThoaiCoDinh(),
            'di_dong'               => $user->getDiDong(),
            'twitter'               => $user->getTwitter(),
            'state'                 => $user->getState(),
        );        
        $user_id = (int) $user->getUserId();
        if ($user_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUserByArrayConditionAndArrayColumn(array('user_id'=>$user_id), array('username'))) {
                $this->tableGateway->update($data, array(
                    'user_id' => $user_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }
}
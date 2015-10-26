<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\Kho;

class KhoTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong phương thức saveSanPham
        sử dụng trong Application/Controller/ChiNhanhController indexAction
    */
    public function getKhoByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'kho'));
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
    public function getKho(){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'kho'));
        $sqlSelect->columns(array('id_kho', 'ten_kho'));        
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['id_kho']] = $resultSet['ten_kho'];
        }
        return $allRow;
    }


    public function saveKho(Kho $kho)
    {
        $data = array(
            'ten_kho'            => $kho->getTenKho(),
            'dia_chi_kho'        => $kho->getDiaChiKho(),
        );        
        $id_kho = (int) $kho->getIdKho();
        if ($id_kho == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getKhoByArrayConditionAndArrayColumn(array('id_kho'=>$id_kho), array('ten_kho'))) {
                $this->tableGateway->update($data, array(
                    'id_kho' => $id_kho
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    public function deleteKho($array=array())
    {
        if ($this->tableGateway->delete($array)) {
            return true;
        }
        return false;
    }
    
}
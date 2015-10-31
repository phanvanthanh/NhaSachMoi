<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\PhieuDoiTra;

class PhieuDoiTraTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong hàm savePhieuDoiTra
    */

    public function getPhieuDoiTraByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_doi_tra'));
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

    public function getPhieuDoiTraAndHoaDonAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array(), $array_columns_3=array(), $array_columns_4=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_doi_tra'));
        $sqlSelect->join(array('t2'=>'hoa_don'), 't1.id_hoa_don=t2.id_hoa_don', $array_columns_2, 'LEFT');
        $sqlSelect->join(array('t3'=>'khach_hang'), 't2.id_khach_hang=t3.id_khach_hang', $array_columns_3, 'LEFT');
        $sqlSelect->join(array('t4'=>'kenh_phan_phoi'), 't3.id_kenh_phan_phoi=t4.id_kenh_phan_phoi', $array_columns_4, 'LEFT');
        if($array_columns_1){
            $sqlSelect->columns($array_columns_1);
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

    public function getPhieuDoiTraAndHoaDonAndCtHoaDonAndKhachHangByArrayConditionAnd5ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array(), $array_columns_3=array(), $array_columns_4=array(), $array_columns_5= array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_doi_tra'));
        $sqlSelect->join(array('t2'=>'hoa_don'), 't1.id_hoa_don=t2.id_hoa_don', $array_columns_2, 'LEFT');
        $sqlSelect->join(array('t3'=>'ct_hoa_don'), 't2.id_hoa_don=t3.id_hoa_don', $array_columns_3, 'LEFT');
        $sqlSelect->join(array('t4'=>'khach_hang'), 't2.id_khach_hang=t4.id_khach_hang', $array_columns_4, 'LEFT');
        $sqlSelect->join(array('t5'=>'kenh_phan_phoi'), 't4.id_kenh_phan_phoi=t5.id_kenh_phan_phoi', $array_columns_5, 'LEFT');
        if($array_columns_1){
            $sqlSelect->columns($array_columns_1);
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
    
}
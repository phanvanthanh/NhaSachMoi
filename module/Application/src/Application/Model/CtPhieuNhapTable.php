<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\CtPhieuNhap;

class CtPhieuNhapTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong ham saveCtPhieuNhap
    */
    public function getCtPhieuNhapByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'ct_phieu_nhap'));
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

    public function saveCtPhieuNhap(CtPhieuNhap $ct_phieu_nhap)
    {
        $data = array(
            'id_san_pham'       => $ct_phieu_nhap->getIdSanPham(),
            'id_phieu_nhap'   	=> $ct_phieu_nhap->getIdPhieuNhap(),
            'gia_nhap'     		=> $ct_phieu_nhap->getGiaNhap(),        
            'so_luong'         	=> $ct_phieu_nhap->getSoLuong(),
            

        );        
        $id_ct_phieu_nhap = (int) $ct_phieu_nhap->getIdCtPhieuNhap();
        if ($id_ct_phieu_nhap == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPhieuNhapByArrayConditionAndArrayColumn(array('id_ct_phieu_nhap'=>$id_ct_phieu_nhap), array('id_san_pham'))) {
                $this->tableGateway->update($data, array(
                    'id_ct_phieu_nhap' => $id_ct_phieu_nhap
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
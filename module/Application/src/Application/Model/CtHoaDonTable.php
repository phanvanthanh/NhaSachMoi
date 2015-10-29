<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\CtHoaDon;

class CtHoaDonTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong ham saveCtHoaDon
    */
    public function getCtHoaDonByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'ct_hoa_don'));
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

    public function saveCtHoaDon(CtHoaDon $ct_hoa_don)
    {
        $data = array(
            'id_hoa_don'   		=> $ct_hoa_don->getIdHoaDon(),
            'id_san_pham'       => $ct_hoa_don->getIdSanPham(),            
            'gia'     			=> $ct_hoa_don->getGia(),        
            'so_luong'         	=> $ct_hoa_don->getSoLuong(),
            'gia_nhap'         	=> $ct_hoa_don->getGiaNhap(),
            'so_luong_tra'      => $ct_hoa_don->getSoLuongTra(),
            'state'             => $ct_hoa_don->getState(),
            

        );        
        $id_ct_hoa_don = (int) $ct_hoa_don->getIdCtHoaDon();
        if ($id_ct_hoa_don == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCtHoaDonByArrayConditionAndArrayColumn(array('id_ct_hoa_don'=>$id_ct_hoa_don), array('id_san_pham'))) {
                $this->tableGateway->update($data, array(
                    'id_ct_hoa_don' => $id_ct_hoa_don
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
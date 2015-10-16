<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\GiaXuat;

class GiaXuatTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    

    /*
        sử dụng trong hàm saveGiaXuat
    */
    public function getGiaXuatByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'gia_xuat'));
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

    public function saveGiaXuat(GiaXuat $gia_xuat)
    {
        $data = array(
            'id_san_pham'       =>$gia_xuat->getIdSanPham(),
            'id_kenh_phan_phoi' =>$gia_xuat->getIdKenhPhanPhoi(),
            'gia_xuat'          =>$gia_xuat->getGiaXuat(),
        );        
        $id_gia_xuat = (int) $gia_xuat->getIdGiaXuat();
        if ($id_gia_xuat == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGiaXuatByArrayConditionAndArrayColumn(array('id_gia_xuat'=>$id_gia_xuat), array('gia_xuat'))) {
                $this->tableGateway->update($data, array(
                    'id_gia_xuat' => $id_gia_xuat
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    public function deleteGiaXuat($array=array())
    {
        if ($this->tableGateway->delete($array)) {
            return true;
        }
        return false;
    }
}
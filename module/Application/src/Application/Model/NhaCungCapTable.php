<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\NhaCungCap;

class NhaCungCapTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong saveNhaCungCap
    */
    public function getNhaCungCapByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'nha_cung_cap'));
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
        sử dụng trong 
    */
    public function saveNhaCungCap(NhaCungCap $nha_cung_cap)
    {
        $data = array(
            'id_kho'			=> $nha_cung_cap->getIdKho(), 
            'ho_ten'            => $nha_cung_cap->getHoTen(), 
            'dia_chi'           => $nha_cung_cap->getDiaChi(), 
            'email'            	=> $nha_cung_cap->getEmail(), 
            'mo_ta'            	=> $nha_cung_cap->getMoTa(), 
            'dien_thoai_co_dinh'=> $nha_cung_cap->getDienThoaiCoDinh(),           
            'di_dong'           => $nha_cung_cap->getDiDong(), 
            'hinh_anh'          => $nha_cung_cap->getHinhAnh(), 
            'state'           	=> $nha_cung_cap->getState(), 
            'ngay_dang_ky'      => $nha_cung_cap->getNgayDangKy(), 
        );        
        $id_nha_cung_cap = (int) $nha_cung_cap->getIdNhaCungCap();
        if ($id_nha_cung_cap == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getNhaCungCapByArrayConditionAndArrayColumn(array('id_nha_cung_cap'=>$id_nha_cung_cap), array('ho_ten'))) {
                $this->tableGateway->update($data, array(
                    'id_nha_cung_cap' => $id_nha_cung_cap
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
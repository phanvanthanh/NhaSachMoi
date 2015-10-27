<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\CongNoNhaCungCap;

class CongNoNhaCungCapTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong phương thức saveSanPham
        sử dụng trong Application/Controller/DoiTacController congNoNhaCungCapAction
    */
    public function getCongNoNhaCungCapByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'cong_no_nha_cung_cap'));
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

    public function getCongNo($array){        
        $adapter = $this->tableGateway->adapter;
        $sql="SELECT t1.ki, t1.id_nha_cung_cap, t3.ho_ten, t1.du_no as no_dau_ki, sum(t5.gia_nhap*t5.so_luong) as no_phat_sinh
            FROM cong_no_nha_cung_cap t1 
            LEFT JOIN cong_no_nha_cung_cap t2 ON (t1.id_nha_cung_cap = t2.id_nha_cung_cap AND t1.id_cong_no < t2.id_cong_no)
            left join nha_cung_cap as t3 on t1.id_nha_cung_cap=t3.id_nha_cung_cap
            left join phieu_nhap as t4 on t1.id_nha_cung_cap=t4.id_nha_cung_cap and t4.state=0
            left join ct_phieu_nhap as t5 on t4.id_phieu_nhap=t5.id_phieu_nhap
            WHERE t2.id_cong_no IS NULL
            GROUP BY t1.id_nha_cung_cap";
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function saveCongNo(CongNoNhaCungCap $cong_no_nha_cung_cap)
    {
        $data = array(
            'id_nha_cung_cap'       =>$cong_no_nha_cung_cap->getIdNhaCungCap(),
            'ki'                    =>$cong_no_nha_cung_cap->getKi(),
            'no_dau_ki'             =>$cong_no_nha_cung_cap->getNoDauKi(),
            'no_phat_sinh'          =>$cong_no_nha_cung_cap->getNoPhatSinh(),
            'du_no'                 =>$cong_no_nha_cung_cap->getDuNo(),
        );        
        $id_cong_no = (int) $cong_no_nha_cung_cap->getIdCongNo();
        if ($id_cong_no == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCongNoNhaCungCapByArrayConditionAndArrayColumn(array('id_cong_no'=>$id_cong_no), array('id_nha_cung_cap'))) {
                $this->tableGateway->update($data, array(
                    'id_cong_no' => $id_cong_no
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
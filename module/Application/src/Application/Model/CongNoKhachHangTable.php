<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\CongNoKhachHang;

class CongNoKhachHangTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong phương thức saveSanPham
        sử dụng trong Application/Controller/DoiTacController congNoKhachHangAction
    */
    public function getCongNoKhachHangByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'cong_no_khach_hang'));
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
        $sql="SELECT t1.ki, t1.du_no, t3.ho_ten, t3.id_khach_hang, sum(t5.gia*t5.so_luong) as no_phat_sinh, t6.kenh_phan_phoi
            FROM cong_no_khach_hang t1 
            LEFT JOIN cong_no_khach_hang t2 ON (t1.id_khach_hang = t2.id_khach_hang AND t1.id_cong_no < t2.id_cong_no)
            left join khach_hang as t3 on t1.id_khach_hang=t3.id_khach_hang
            left join hoa_don as t4 on t1.id_khach_hang=t4.id_khach_hang and t4.state=0
            left join ct_hoa_don as t5 on t4.id_hoa_don=t5.id_hoa_don
            left join kenh_phan_phoi as t6 on t3.id_kenh_phan_phoi=t6.id_kenh_phan_phoi
            WHERE t2.id_cong_no IS NULL
            GROUP BY t1.id_khach_hang";
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function saveCongNo(CongNoKhachHang $cong_no_khach_hang)
    {
        $data = array(
            'id_khach_hang'         =>$cong_no_khach_hang->getIdKhachHang(),
            'ki'                    =>$cong_no_khach_hang->getKi(),
            'no_dau_ki'             =>$cong_no_khach_hang->getNoDauKi(),
            'no_phat_sinh'          =>$cong_no_khach_hang->getNoPhatSinh(),
            'du_no'                 =>$cong_no_khach_hang->getDuNo(),
        );        
        $id_cong_no = (int) $cong_no_khach_hang->getIdCongNo();
        if ($id_cong_no == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCongNoKhachHangByArrayConditionAndArrayColumn(array('id_cong_no'=>$id_cong_no), array('id_khach_hang'))) {
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
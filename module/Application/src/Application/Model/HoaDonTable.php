<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\HoaDon;

class HoaDonTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong hàm saveHoaDon
    */

    public function getHoaDonByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'hoa_don'));
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
        sử dụng trong Application/Controller/DoiTacController congNoKhachHangAction
    */
    public function getHoaDonAndCtHoaDonByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'hoa_don'));
        $sqlSelect->join(array('t2'=>'ct_hoa_don'), 't1.id_hoa_don=t2.id_hoa_don', $array_columns_2, 'LEFT');
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

    /*
        sử dụng trong: Application/Controller/Plugin/TaoMaTuDong taoMaHoaDon
    */
    public function countHoaDonByMaHoaDon($array=array()){
        $ma_hoa_don=$array['ma_hoa_don'];
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'hoa_don'));
        $sqlSelect->columns(array(new Expression('COUNT(*) as num')));
        $where = new \Zend\Db\Sql\Where();
        $where->like('ma_hoa_don', '%'.$ma_hoa_don.'%');
        $sqlSelect->where($where);
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();

        if($resultSets->current()){
            return $resultSets->current();
        }
        return false;

    }

    public function saveHoaDon(HoaDon $hoa_don)
    {
        $data = array(
            'id_user'           => $hoa_don->getIdUser(),
            'id_khach_hang'     => $hoa_don->getIdKhachHang(),
            'ma_hoa_don'        => $hoa_don->getMaHoaDon(),        
            'ngay_xuat'         => $hoa_don->getNgayXuat(),
            'state'             => $hoa_don->getState(),
        );        
        $id_hoa_don = (int) $hoa_don->getIdHoaDon();
        if ($id_hoa_don == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getHoaDonByArrayConditionAndArrayColumn(array('id_hoa_don'=>$id_hoa_don), array('ma_hoa_don'))) {
                $this->tableGateway->update($data, array(
                    'id_hoa_don' => $id_hoa_don
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
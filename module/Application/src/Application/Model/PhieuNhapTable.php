<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\PhieuNhap;

class PhieuNhapTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Application/Controller/DoiTacController congNoNhaCungCapAction
    */
    public function getPhieuNhapAndCtPhieuNhapByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_nhap'));
        $sqlSelect->join(array('t2'=>'ct_phieu_nhap'), 't1.id_phieu_nhap=t2.id_phieu_nhap', $array_columns_2, 'LEFT');
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

    public function getPhieuNhap($array){
        $id_phieu_nhap=$array['id_phieu_nhap'];
        $id_kho=$array['id_kho'];
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_nhap'));
        $sqlSelect->join(array('t2'=>'ct_phieu_nhap'), 't1.id_phieu_nhap=t2.id_phieu_nhap', array('gia_nhap', 'so_luong'), 'LEFT');
        $sqlSelect->join(array('t3'=>'san_pham'), 't2.id_san_pham=t3.id_san_pham', array('ten_san_pham', 'ma_san_pham', 'ma_vach'), 'LEFT');
        $sqlSelect->join(array('t4'=>'don_vi_tinh'), 't3.id_don_vi_tinh=t4.id_don_vi_tinh', array('don_vi_tinh'), 'LEFT');
        $sqlSelect->join(array('t5'=>'nha_cung_cap'), 't1.id_nha_cung_cap=t5.id_nha_cung_cap', array('ho_ten'), 'LEFT');
        $sqlSelect->columns(array('ma_phieu_nhap', 'ngay_nhap'));        
        $sqlSelect->where(array('t1.id_phieu_nhap'=>$id_phieu_nhap, 't5.id_kho'=>$id_kho));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    /*
        sử dụng trong: Application/Controller/Plugin/TaoMaTuDong taoMaPhieuNhap
    */
    public function countPhieuNhapByMaPhieuNhap($array=array()){
        $ma_phieu_nhap=$array['ma_phieu_nhap'];
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_nhap'));
        $sqlSelect->columns(array(new Expression('COUNT(*) as num')));
        $where = new \Zend\Db\Sql\Where();
        $where->like('ma_phieu_nhap', '%'.$ma_phieu_nhap.'%');
        $sqlSelect->where($where);
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();

        if($resultSets->current()){
            return $resultSets->current();
        }
        return false;

    }
    

    /*
        sử dụng trong ham savePhieuNhap
    */
    public function getPhieuNhapByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_nhap'));
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

    public function savePhieuNhap(PhieuNhap $phieu_nhap)
    {
        $data = array(
            'id_user'           => $phieu_nhap->getIdUser(),
            'id_nha_cung_cap'   => $phieu_nhap->getIdNhaCungCap(),
            'ma_phieu_nhap'     => $phieu_nhap->getMaPhieuNhap(),        
            'ngay_nhap'         => $phieu_nhap->getNgayNhap(),
            'state'             => $phieu_nhap->getState(),
            

        );        
        $id_phieu_nhap = (int) $phieu_nhap->getIdPhieuNhap();
        if ($id_phieu_nhap == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPhieuNhapByArrayConditionAndArrayColumn(array('id_phieu_nhap'=>$id_phieu_nhap), array('ma_phieu_nhap'))) {
                $this->tableGateway->update($data, array(
                    'id_phieu_nhap' => $id_phieu_nhap
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    public function deletePhieuNhap($array=array())
    {
        if ($this->tableGateway->delete($array)) {
            return true;
        }
        return false;
    }

    public function getPhieuNhapAndNhaCungCapByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_nhap'));
        $sqlSelect->join(array('t2'=>'nha_cung_cap'), 't1.id_nha_cung_cap=t2.id_nha_cung_cap', $array_columns_2, 'LEFT');
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
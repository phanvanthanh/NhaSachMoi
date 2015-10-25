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

    /*
        sử dụng trong Application/Controller/DoiTacController congNoKhachHangAction
    */
    public function getHoaDonAndUserAndKhachHangAndKenhPhanPhoiByArrayConditionAnd4ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array(), $array_columns_3=array(), $array_columns_4=array()){
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
        $sqlSelect->join(array('t2'=>'user'), 't1.id_user=t2.user_id', $array_columns_2, 'LEFT');
        $sqlSelect->join(array('t3'=>'khach_hang'), 't1.id_khach_hang=t3.id_khach_hang', $array_columns_3, 'LEFT');
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

    public function getHoaDon($array){
        $id_hoa_don=$array['id_hoa_don'];
        $id_kho=$array['id_kho'];
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'hoa_don'));
        $sqlSelect->join(array('t2'=>'ct_hoa_don'), 't1.id_hoa_don=t2.id_hoa_don', array('gia', 'so_luong', 'gia_nhap'), 'LEFT');
        $sqlSelect->join(array('t3'=>'san_pham'), 't2.id_san_pham=t3.id_san_pham', array('ten_san_pham', 'ma_san_pham', 'ma_vach'), 'LEFT');
        $sqlSelect->join(array('t4'=>'don_vi_tinh'), 't3.id_don_vi_tinh=t4.id_don_vi_tinh', array('don_vi_tinh'), 'LEFT');
        $sqlSelect->join(array('t5'=>'khach_hang'), 't1.id_khach_hang=t5.id_khach_hang', array('ho_ten'), 'LEFT');
        $sqlSelect->columns(array('ma_hoa_don', 'ngay_xuat'));        
        $sqlSelect->where(array('t1.id_hoa_don'=>$id_hoa_don, 't3.id_kho'=>$id_kho));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function getDoanhThu($array){
        $where='';
        if(isset($array['where'])){
            $where='and t4.id_kenh_phan_phoi='.$array['where'];
        }
        $loai_doanh_thu='%d-%m-%Y';
        if(isset($array['loai_doanh_thu'])){
            $loai_doanh_thu_=$array['loai_doanh_thu'];
            if($loai_doanh_thu_=='thang'){
                 $loai_doanh_thu='%m-%Y';
            }
            elseif ($loai_doanh_thu_=='nam') {
                 $loai_doanh_thu='%Y';
            }
        }
        $id_kho=$array['id_kho'];
        $adapter = $this->tableGateway->adapter;
        $sql='select 
            DATE_FORMAT(t1.ngay_xuat,"'.$loai_doanh_thu.'") as thoi_gian, 
            count(DISTINCT  t1.ma_hoa_don) as so_hoa_don, 
            t4.id_kenh_phan_phoi, t4.kenh_phan_phoi,
            sum(t2.gia*t2.so_luong) as doanh_thu, 
            sum(t2.gia_nhap*t2.so_luong) as von 
            from hoa_don as t1
            left join ct_hoa_don as t2 on t1.id_hoa_don=t2.id_hoa_don
            left join khach_hang as t3 on t1.id_khach_hang=t3.id_khach_hang
            left join kenh_phan_phoi as t4 on t3.id_kenh_phan_phoi=t4.id_kenh_phan_phoi
            where t4.id_kho='.$id_kho.' '.$where.'
            group by DATE_FORMAT(t1.ngay_xuat,"'.$loai_doanh_thu.'")';
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function getChiTietDoanhThu($array){        
        $id_kho=$array['id_kho'];
        $date=$array['date_value'];
        $date_type=$array['date_type'];
        $adapter = $this->tableGateway->adapter;
        $dieu_kien_1='%d-%m-%Y';
        $dieu_kien_2=$date;
        if($date_type=='thang'){
            $dieu_kien_1='%m-%Y';
        }
        elseif($date_type=='nam'){
            $dieu_kien_1='%Y';
        }
        $sql='select t5.kenh_phan_phoi, t1.id_khach_hang, t4.ho_ten, t1.ma_hoa_don, t1.id_hoa_don, t1.ngay_xuat, sum(t2.gia*t2.so_luong) as doanh_thu, sum(t2.gia_nhap*t2.so_luong) as von
            from hoa_don as t1
            left join ct_hoa_don as t2 on t1.id_hoa_don=t2.id_hoa_don
            left join san_pham as t3 on t2.id_san_pham=t3.id_san_pham
            left join khach_hang as t4 on t1.id_khach_hang=t4.id_khach_hang
            left join kenh_phan_phoi as t5 on t4.id_kenh_phan_phoi=t5.id_kenh_phan_phoi
            where DATE_FORMAT(t1.ngay_xuat, "'.$dieu_kien_1.'")="'.$dieu_kien_2.'" and t3.id_kho='.$id_kho.'
            group by t1.ma_hoa_don';
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }
    
}
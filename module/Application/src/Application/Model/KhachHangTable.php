<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\KhachHang;

class KhachHangTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /*
        sử dụng trong saveKhachHang
    */
    public function getKhachHangByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'khach_hang'));
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
        sử dụng trong Application/Controller/DoiTacController indexAction
        sử dụng trong Application/Controller/DoiTacController suaThongTinKhachHangAction
        sử dụng trong Application/Controller/DoiTacController xoaThongTinKhachHangAction
        sử dụng trong Application/Controller/DoiTacController congNoKhachHangAction
    */
    public function getKhachHangAndKenhPhanPhoiByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'khach_hang'));
        $sqlSelect->join(array('t2'=>'kenh_phan_phoi'), 't1.id_kenh_phan_phoi=t2.id_kenh_phan_phoi', $array_columns_2, 'LEFT');
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
        sử dụng trong Application/Controller/DoiTacController createDataKhachHangAction
        sử dụng trong Application/Controller/DoiTacController themKhachHangAction
        sử dụng trong Application/Controller/DoiTacController suaThongTinKhachHangAction
        sử dụng trong Application/Controller/DoiTacController xoaThongTinKhachHangAction
    */
    public function saveKhachHang(KhachHang $khach_hang)
    {
        $data = array(
            'id_kenh_phan_phoi'	=> $khach_hang->getIdKenhPhanPhoi(), 
            'ho_ten'            => $khach_hang->getHoTen(), 
            'dia_chi'           => $khach_hang->getDiaChi(), 
            'email'            	=> $khach_hang->getEmail(), 
            'mo_ta'            	=> $khach_hang->getMoTa(), 
            'dien_thoai_co_dinh'=> $khach_hang->getDienThoaiCoDinh(),           
            'di_dong'           => $khach_hang->getDiDong(), 
            'hinh_anh'          => $khach_hang->getHinhAnh(), 
            'state'           => $khach_hang->getState(), 
            'ngay_dang_ky'      => $khach_hang->getNgayDangKy(), 
        );        
        $id_khach_hang = (int) $khach_hang->getIdKhachHang();
        if ($id_khach_hang == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getKhachHangByArrayConditionAndArrayColumn(array('id_khach_hang'=>$id_khach_hang), array('ho_ten'))) {
                $this->tableGateway->update($data, array(
                    'id_khach_hang' => $id_khach_hang
                ));
            } else {
                return false;
            }
        }
        return true;
    }
}
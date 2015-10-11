<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\SanPham;

class SanPhamTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong phương thức saveSanPham
        sử dụng trong Application/Controller/HangHoaController themSanPhamAction
        sử dụng trong Application/Controller/HangHoaController suaSanPhamAction
        sử dụng trong Application/Controller/HangHoaController xoaSanPhamAction
    */
    public function getSanPhamByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'san_pham'));
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
        sử dụng trong Application/Controller/HangHoaController indexAction
    */
    public function getSanPhamAndLoaiSanPhamByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'san_pham'));
        $sqlSelect->join(array('t2'=>'loai_san_pham'), 't1.id_loai_san_pham=t2.id_loai_san_pham', $array_columns_2, 'LEFT');
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
        sử dụng trong Application/Controller/HangHoaController themSanPhamAction
        sử dụng trong Application/Controller/HangHoaController suaSanPhamAction
        sử dụng trong Application/Controller/HangHoaController xoaSanPhamAction
        sử dụng trong Application/Controller/HangHoaController createDataAction
    */
    public function saveSanPham(SanPham $san_pham)
    {
        $data = array(
            'id_kho'            => $san_pham->getIdKho(),
            'id_don_vi_tinh'    => $san_pham->getIdDonViTinh(),
            'id_barcode'        => $san_pham->getIdBarcode(),
            'ma_san_pham'       => $san_pham->getMaSanPham(),
            'ma_vach'           => $san_pham->getMaVach(),
            'id_loai_san_pham'     => $san_pham->getIdLoaiSanPham(),
            'ten_san_pham'      => $san_pham->getTenSanPham(),
            'mo_ta'             => $san_pham->getMoTa(),
            'hinh_anh'          => $san_pham->getHinhAnh(),
            'nhan'              => $san_pham->getNhan(),
            'ton_kho'           => $san_pham->getTonKho(),
            'loai_gia'          => $san_pham->getLoaiGia(),
            'gia_nhap'          => $san_pham->getGiaNhap(),
            'gia_bia'           => $san_pham->getGiaBia(),
            'chiet_khau'        => $san_pham->getChietKhau(),
            'state'             => $san_pham->getState(),
            'user_id'           => $san_pham->getUserId(),

        );        
        $id_san_pham = (int) $san_pham->getIdSanPham();
        if ($id_san_pham == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getSanPhamByArrayConditionAndArrayColumn(array('id_san_pham'=>$id_san_pham), array('ten_san_pham'))) {
                $this->tableGateway->update($data, array(
                    'id_san_pham' => $id_san_pham
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    
}
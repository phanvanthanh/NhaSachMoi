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
        sử dụng trong Application/Controller/HangHoaController indexAction
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

    public function saveSanPham(SanPham $san_pham)
    {
        $data = array(
            'id_kho'            => $san_pham->getIdKho(),
            'id_don_vi_tinh'    => $san_pham->getIdDonViTinh(),
            'id_barcode'        => $san_pham->getIdBarcode(),
            'ma_san_pham'       => $san_pham->getMaSanPham(),
            'ma_vach'           => $san_pham->getMaVach(),
            'loai_san_pham'     => $san_pham->getLoaiSanPham(),
            'ten_san_pham'      => $san_pham->getTenSanPham(),
            'mo_ta'             => $san_pham->getMoTa(),
            'hinh_anh'          => $san_pham->getHinhAnh(),
            'nhan'              => $san_pham->getNhan(),
            'ton_kho'           => $san_pham->getTonKho(),
            'loai_gia'          => $san_pham->getLoaiGia(),
            'gia_nhap'          => $san_pham->getGiaNhap(),
            'gia_bia'           => $san_pham->getGiaBia(),
            'chiec_khau'        => $san_pham->getChiecKhau()

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
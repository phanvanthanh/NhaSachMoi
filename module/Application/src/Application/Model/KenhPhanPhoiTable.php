<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\KenhPhanPhoi;

class KenhPhanPhoiTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Application\Factory\Form\ThemKhachHangFormFactory
        sử dụng trong Application\Factory\Form\SuaThongTinKhachHangFormFactory
        sử dụng trong Application\Factory\Form\SuaSanPhamFormFactory
    */
    public function getKenhPhanPhoiByIdKho($id_kho){
    	$adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'kenh_phan_phoi'));
        $sqlSelect->columns(array('id_kenh_phan_phoi', 'kenh_phan_phoi'));
        $sqlSelect->where(array('id_kho'=>$id_kho));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['id_kenh_phan_phoi']] = $resultSet['kenh_phan_phoi'];
        }
        return $allRow;
    }


    public function getKenhPhanPhoiByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'kenh_phan_phoi'));
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

    public function getIdKenhPhanPhoiAndGiaXuatByIdKhoAndIdSanPham($array){
        $id_kho=$array['id_kho'];
        $id_san_pham=$array['id_san_pham'];

        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'kenh_phan_phoi'));
        $sqlSelect->columns(array('id_kenh_phan_phoi'));
        $sqlSelect->join(array('t2'=>'gia_xuat'), new Expression('t1.id_kenh_phan_phoi=t2.id_kenh_phan_phoi and t2.id_san_pham='.$id_san_pham), array('gia_xuat'), 'LEFT' );
        $sqlSelect->where(array('t1.id_kho'=>$id_kho));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow['id_kenh_pha_phoi_'.$resultSet['id_kenh_phan_phoi']] = $resultSet['gia_xuat'];
        }
        return $allRow;
    }

    public function saveKenhPhanPhoi(KenhPhanPhoi $kenh_phan_phoi)
    {
        $data = array(
            'id_kho'            => $kenh_phan_phoi->getIdKho(), 
            'kenh_phan_phoi'    => $kenh_phan_phoi->getKenhPhanPhoi(), 
            'chiet_khau_xuong'        => $kenh_phan_phoi->getChietKhauXuong(), 
            'chiet_khau_len'        => $kenh_phan_phoi->getChietKhauLen(), 
        );        
        $id_kenh_phan_phoi = (int) $kenh_phan_phoi->getIdKenhPhanPhoi();
        if ($id_kenh_phan_phoi == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getKenhPhanPhoiByArrayConditionAndArrayColumn(array('id_kenh_phan_phoi'=>$id_kenh_phan_phoi), array('kenh_phan_phoi'))) {
                $this->tableGateway->update($data, array(
                    'id_kenh_phan_phoi' => $id_kenh_phan_phoi
                ));
            } else {
                return false;
            }
        }
        return true;
    }
    
}
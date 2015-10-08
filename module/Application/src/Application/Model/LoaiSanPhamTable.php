<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\LoaiSanPham;

class LoaiSanPhamTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Application\Factory\Form\ThemSanPhamFormFactory
    */
    public function getLoaiSanPhamByIdKho($id_kho){
    	$adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'loai_san_pham'));
        $sqlSelect->columns(array('id_loai_san_pham', 'loai_san_pham'));
        $sqlSelect->where(array('id_kho'=>$id_kho));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['id_loai_san_pham']] = $resultSet['loai_san_pham'];
        }
        return $allRow;
    }
    
}
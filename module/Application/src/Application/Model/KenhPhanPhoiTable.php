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
    
}
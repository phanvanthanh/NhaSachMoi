<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\PhieuThu;

class PhieuThuTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function tongHopThuChi($array){  
    	$where='WHERE user.id_kho='.$array['id_kho'];
    	if(isset($array['thoi_gian_bat_dau']) and isset($array['thoi_gian_ket_thuc'])){
    		$where.="AND ngay_thanh_toan>='".$array['thoi_gian_bat_dau']."' and ngay_thanh_toan<='".$array['thoi_gian_ket_thuc']."'";
    	}      
        $adapter = $this->tableGateway->adapter;
        $sql="SELECT  tong_hop.*  FROM  (
			select id_user, ma_phieu_thu as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_thu' as loai from phieu_thu
			union  all
			select id_user, ma_phieu_chi as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_chi' as loai from phieu_chi
			union all
            select id_user, ma_phieu_chi as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_chi' as loai from phieu_chi_khach_hang
            ) as tong_hop 
            left join user on user.user_id=tong_hop.id_user 
            ".$where."            		
			ORDER   BY ngay_thanh_toan, loai";           
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function getPhieuThuAndUserByArrayConditionAnd2ArrayColumn($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột ở bảng 1 cần lấy ra,
                                    1 tham số là mảng cột ở bảng 2 cần lấy ra,
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'phieu_thu'));
        $sqlSelect->join(array('t2'=>'user'), 't1.id_user=t2.user_id', $array_columns_2, 'LEFT');
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
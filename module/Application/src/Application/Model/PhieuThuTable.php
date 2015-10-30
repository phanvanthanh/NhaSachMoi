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
    	$where='';
    	if(isset($array['thoi_gian_bat_dau']) and isset($array['thoi_gian_ket_thuc'])){
    		$where="WHERE  ngay_thanh_toan>='".$array['thoi_gian_bat_dau']."' and ngay_thanh_toan<='".$array['thoi_gian_ket_thuc']."'";
    	}      
        $adapter = $this->tableGateway->adapter;
        $sql="SELECT  *  FROM  (
			select ma_phieu_thu as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_thu' as loai from phieu_thu
			union  all
			select ma_phieu_chi as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_chi' as loai from phieu_chi
			union all
            select ma_phieu_chi as ma, ly_do, ngay_thanh_toan, so_tien, 'phieu_chi' as loai from phieu_chi_khach_hang
            ) as tong_hop ".$where."			
			ORDER   BY ngay_thanh_toan, loai";
        $statement = $adapter->query($sql);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    
    
}
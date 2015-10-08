<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\LoaiSanPham;
use Application\Model\LoaiSanPhamTable;

class LoaiSanPhamTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new LoaiSanPham());
        $tableGateway = new TableGateway('loai_san_pham', $adapter, null, $resultSetPrototype);
        return new LoaiSanPhamTable($tableGateway);
    }
}
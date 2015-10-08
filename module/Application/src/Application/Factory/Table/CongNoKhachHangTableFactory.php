<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\CongNoKhachHang;
use Application\Model\CongNoKhachHangTable;

class CongNoKhachHangTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CongNoKhachHang());
        $tableGateway = new TableGateway('cong_no_khach_hang', $adapter, null, $resultSetPrototype);
        return new CongNoKhachHangTable($tableGateway);
    }
}
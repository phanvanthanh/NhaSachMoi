<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\PhieuChiKhachHang;
use Application\Model\PhieuChiKhachHangTable;

class PhieuChiKhachHangTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PhieuChiKhachHang());
        $tableGateway = new TableGateway('phieu_chi_khach_hang', $adapter, null, $resultSetPrototype);
        return new PhieuChiKhachHangTable($tableGateway);
    }
}
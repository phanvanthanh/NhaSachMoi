<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\CtPhieuNhap;
use Application\Model\CtPhieuNhapTable;

class CtPhieuNhapTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CtPhieuNhap());
        $tableGateway = new TableGateway('ct_phieu_nhap', $adapter, null, $resultSetPrototype);
        return new CtPhieuNhapTable($tableGateway);
    }
}
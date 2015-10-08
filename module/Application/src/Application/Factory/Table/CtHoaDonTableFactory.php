<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\CtHoaDon;
use Application\Model\CtHoaDonTable;

class CtHoaDonTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CtHoaDon());
        $tableGateway = new TableGateway('ct_hoa_don', $adapter, null, $resultSetPrototype);
        return new CtHoaDonTable($tableGateway);
    }
}
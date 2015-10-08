<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\DonViTinh;
use Application\Model\DonViTinhTable;

class DonViTinhTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new DonViTinh());
        $tableGateway = new TableGateway('don_vi_tinh', $adapter, null, $resultSetPrototype);
        return new DonViTinhTable($tableGateway);
    }
}
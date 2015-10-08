<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\NhaCungCap;
use Application\Model\NhaCungCapTable;

class NhaCungCapTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new NhaCungCap());
        $tableGateway = new TableGateway('nha_cung_cap', $adapter, null, $resultSetPrototype);
        return new NhaCungCapTable($tableGateway);
    }
}
<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\CongNoNhaCungCap;
use Application\Model\CongNoNhaCungCapTable;

class CongNoNhaCungCapTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CongNoNhaCungCap());
        $tableGateway = new TableGateway('cong_no_nha_cung_cap', $adapter, null, $resultSetPrototype);
        return new CongNoNhaCungCapTable($tableGateway);
    }
}
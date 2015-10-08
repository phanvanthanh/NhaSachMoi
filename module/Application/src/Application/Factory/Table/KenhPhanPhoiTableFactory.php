<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\KenhPhanPhoi;
use Application\Model\KenhPhanPhoiTable;

class KenhPhanPhoiTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new KenhPhanPhoi());
        $tableGateway = new TableGateway('kenh_phan_phoi', $adapter, null, $resultSetPrototype);
        return new KenhPhanPhoiTable($tableGateway);
    }
}
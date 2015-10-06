<?php
namespace Application\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyNavigationRightFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new MyNavigationRight($serviceLocator);
        return $navigation->createService($serviceLocator);
    }
}
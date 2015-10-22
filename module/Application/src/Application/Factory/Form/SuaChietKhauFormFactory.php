<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaChietKhauForm;
use Application\Form\SuaChietKhauFormFilter;

class SuaChietKhauFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaChietKhauForm(); 
        
        $form->setInputFilter(new SuaChietKhauFormFilter());
        
        return $form;
    }
}
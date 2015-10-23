<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaChiNhanhForm;
use Application\Form\SuaChiNhanhFormFilter;

class SuaChiNhanhFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaChiNhanhForm(); 
        
        $form->setInputFilter(new SuaChiNhanhFormFilter());
        
        return $form;
    }
}
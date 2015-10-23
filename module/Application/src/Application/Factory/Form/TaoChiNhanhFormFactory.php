<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\TaoChiNhanhForm;
use Application\Form\TaoChiNhanhFormFilter;

class TaoChiNhanhFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new TaoChiNhanhForm(); 
        
        $form->setInputFilter(new TaoChiNhanhFormFilter());
        
        return $form;
    }
}
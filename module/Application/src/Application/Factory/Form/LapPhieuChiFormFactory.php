<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\LapPhieuChiForm;
use Application\Form\LapPhieuChiFormFilter;

class LapPhieuChiFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new LapPhieuChiForm(); 
        
        $form->setInputFilter(new LapPhieuChiFormFilter());
        
        return $form;
    }
}
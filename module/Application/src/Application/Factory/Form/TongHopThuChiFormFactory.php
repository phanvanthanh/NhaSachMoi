<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\TongHopThuChiForm;
use Application\Form\TongHopThuChiFormFilter;

class TongHopThuChiFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new TongHopThuChiForm(); 
        
        $form->setInputFilter(new TongHopThuChiFormFilter());
        
        return $form;
    }
}
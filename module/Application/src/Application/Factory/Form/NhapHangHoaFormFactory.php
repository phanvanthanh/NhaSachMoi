<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\NhapHangHoaForm;
use Application\Form\NhapHangHoaFormFilter;

class NhapHangHoaFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new NhapHangHoaForm(); 
        
        $form->setInputFilter(new NhapHangHoaFormFilter());
        
        return $form;
    }
}
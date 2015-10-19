<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\XuatHangHoaForm;
use Application\Form\XuatHangHoaFormFilter;

class XuatHangHoaFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new XuatHangHoaForm(); 
        
        $form->setInputFilter(new XuatHangHoaFormFilter());
        
        return $form;
    }
}
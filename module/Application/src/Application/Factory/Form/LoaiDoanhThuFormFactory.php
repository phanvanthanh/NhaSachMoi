<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\LoaiDoanhThuForm;
use Application\Form\LoaiDoanhThuFormFilter;

class LoaiDoanhThuFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new LoaiDoanhThuForm(); 
        
        $form->setInputFilter(new LoaiDoanhThuFormFilter());
        
        return $form;
    }
}
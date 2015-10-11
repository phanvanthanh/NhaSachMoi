<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\ThemNhaCungCapForm;
use Application\Form\ThemNhaCungCapFormFilter;

class ThemNhaCungCapFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new ThemNhaCungCapForm();
        
        $form->setInputFilter(new ThemNhaCungCapFormFilter());
        
        return $form;
    }
}
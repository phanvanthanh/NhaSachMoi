<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaThongTinNhaCungCapForm;
use Application\Form\SuaThongTinNhaCungCapFormFilter;

class SuaThongTinNhaCungCapFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaThongTinNhaCungCapForm();
        
        $form->setInputFilter(new SuaThongTinNhaCungCapFormFilter());
        
        return $form;
    }
}
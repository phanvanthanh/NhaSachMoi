<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\LapPhieuThuForm;
use Application\Form\LapPhieuThuFormFilter;

class LapPhieuThuFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new LapPhieuThuForm(); 
        
        $form->setInputFilter(new LapPhieuThuFormFilter());
        
        return $form;
    }
}
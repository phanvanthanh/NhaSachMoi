<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\ThemSanPhamForm;
use Application\Form\ThemSanPhamFormFilter;

class ThemSanPhamFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new ThemSanPhamForm();        
        
        $value_options=array();
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_don_vi_tinh',
            'options' => array(
                'label' => 'Chọn đơn vị tính',
                'empty_option' => '-----Chọn-----',
                'value_options' => $value_options,
            )
        ));
        
        $form->setInputFilter(new ThemSanPhamFormFilter());
        
        return $form;
    }
}
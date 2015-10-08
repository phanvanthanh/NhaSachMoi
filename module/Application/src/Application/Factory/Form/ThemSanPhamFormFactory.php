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
        
        $don_vi_tinh_value_options=array();
        $storage=$serviceLocator->get('AuthService')->getStorage();
        $read=$storage->read();
        $id_kho=$read['id_kho'];
        $don_vi_tinh_table=$serviceLocator->get('Application\Model\DonViTinhTable');
        $don_vi_tinh_value_options=$don_vi_tinh_table->getDonViTinhByKhoId($id_kho);
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_don_vi_tinh',
            'options' => array(
                'label' => 'Chọn đơn vị tính',
                'empty_option' => '-----Chọn-----',
                'value_options' => $don_vi_tinh_value_options,
            )
        ));
        
        $form->setInputFilter(new ThemSanPhamFormFilter());
        
        return $form;
    }
}
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
        $storage=$serviceLocator->get('AuthService')->getStorage();
        $read=$storage->read();
        $id_kho=$read['id_kho'];

        $don_vi_tinh_value_options=array();
        $don_vi_tinh_table=$serviceLocator->get('Application\Model\DonViTinhTable');
        $don_vi_tinh_value_options=$don_vi_tinh_table->getDonViTinhByIdKho($id_kho);
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_don_vi_tinh',
            'options' => array(
                'label' => 'Chọn đơn vị tính',
                'empty_option' => '-----Chọn-----',
                'value_options' => $don_vi_tinh_value_options,
            ),
            'attributes'    => array(
                'class' => 'form-control'
            ),
        ));


        $loai_san_pham_value_options=array();
        $loai_san_pham_table=$serviceLocator->get('Application\Model\LoaiSanPhamTable');
        $loai_san_pham_value_options=$loai_san_pham_table->getLoaiSanPhamByIdKho($id_kho);
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_loai_san_pham',
            'options' => array(
                'label' => 'Chọn loại sản phẩm',
                'empty_option' => '-----Chọn-----',
                'value_options' => $loai_san_pham_value_options,
            ),
            'attributes'    => array(
                'class' => 'form-control'
            ),
        ));
        
        $form->setInputFilter(new ThemSanPhamFormFilter());
        
        return $form;
    }
}
<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaSanPhamForm;
use Application\Form\SuaSanPhamFormFilter;

class SuaSanPhamFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaSanPhamForm(); 
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

        $kenh_phan_phoi_table=$serviceLocator->get('Application\Model\KenhPhanPhoiTable');
        $kenh_phan_phoi=$kenh_phan_phoi_table->getKenhPhanPhoiByIdKho($id_kho);
        foreach ($kenh_phan_phoi as $key => $value) {
            $form->add(array(
                'name' => 'id_kenh_pha_phoi_'.$key,
                'type' => 'Zend\Form\Element\Number',
                'options' => array(
                    'label' => $value
                ),
                'attributes' => array(
                    'title' => $value,
                    'class' => 'form-control'
                )
            ));
        }
        $form->setInputFilter(new SuaSanPhamFormFilter());
        
        return $form;
    }
}
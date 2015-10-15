<?php
namespace Application\Form;

use Zend\Form\Form;
/*
    sử dụng trong Application/Controller/HangHoaController themSanPhamAction
*/
class NhapHangHoaForm extends Form
{

    public function __construct()
    {
        parent::__construct("them-san-pham");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id_nha_cung_cap',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Id nhà cung cấp"
            ),
            'attributes' => array(
                'title' => 'Id nhà cung cấp',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'id_san_pham',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Id sản phẩm"
            ),
            'attributes' => array(
                'title' => 'Id sản phẩm',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'so_luong',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Số lượng"
            ),
            'attributes' => array(
                'title' => 'Số lượng',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'gia_nhap',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Giá nhập"
            ),
            'attributes' => array(
                'title' => 'Giá nhập',
                'class' => 'form-control'
            )
        ));

        
    }
}
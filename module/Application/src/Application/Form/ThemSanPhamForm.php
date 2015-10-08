<?php
namespace Application\Form;

use Zend\Form\Form;
/*
    sử dụng trong Application/Controller/HangHoaController themSanPhamAction
*/
class ThemSanPhamForm extends Form
{

    public function __construct()
    {
        parent::__construct("them-san-pham");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'ma_san_pham',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Mã sản phẩm"
            ),
            'attributes' => array(
                'title' => 'Mã sản phẩm',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'ma_vach',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Mã vạch"
            ),
            'attributes' => array(
                'title' => 'Mã vạch',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'loai_san_pham',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Loại sản phẩm"
            ),
            'attributes' => array(
                'title' => 'Loại sản phẩm',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'ten_san_pham',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Tên sản phẩm"
            ),
            'attributes' => array(
                'title' => 'Tên sản phẩm',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'mo_ta',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => "Mô tả"
            ),
            'attributes' => array(
                'title' => 'Mô tả',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'hinh_anh',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => "Hình ảnh"
            ),
            'attributes' => array(
                'title' => 'Hình ảnh',
                'class' => ''
            )
        ));

        $this->add(array(
            'name' => 'nhan',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Nhản sản phẩm"
            ),
            'attributes' => array(
                'title' => 'Nhản sản phẩm',
                'class' => ''
            )
        ));

        $this->add(array(
            'name' => 'loai_gia',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => "Loại giá",
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
            'attributes' => array(
                'title' => 'Loại giá',
                'class' => ''
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
                'class' => ''
            )
        ));

        $this->add(array(
            'name' => 'gia_bia',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Giá bìa"
            ),
            'attributes' => array(
                'title' => 'Giá bìa',
                'class' => ''
            )
        ));

        $this->add(array(
            'name' => 'chiet_khau',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Chiết khấu"
            ),
            'attributes' => array(
                'title' => 'Chiết khấu',
                'class' => ''
            )
        ));
    }
}
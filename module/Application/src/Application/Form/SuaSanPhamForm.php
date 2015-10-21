<?php
namespace Application\Form;

use Zend\Form\Form;
/*
    sử dụng trong Application/Controller/HangHoaController themSanPhamAction
*/
class SuaSanPhamForm extends Form
{

    public function __construct()
    {
        parent::__construct("sua-san-pham");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id_san_pham',
            'type' => 'Zend\Form\Element\Hidden'            
        ));

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
                'label' => 'Mô tả'
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
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'loai_gia',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => "Sản phẩm có giá in trên bìa",
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
            'attributes' => array(
                'title' => 'Sản phẩm có giá in trên bìa',
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
                'class' => 'form-control'
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
                'class' => 'form-control'
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
                'class' => 'form-control'
            )
        ));

    }
}
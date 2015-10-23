<?php
namespace Application\Form;

use Zend\Form\Form;

class SuaChiNhanhForm extends Form
{

    public function __construct()
    {
        parent::__construct("sua_chi_nhanh");
        $this->setAttribute('method', 'post');  
        $this->add(array(
            'name' => 'id_kho',
            'type' => 'Zend\Form\Element\Hidden',           
        ));      

        $this->add(array(
            'name' => 'ten_kho',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Tên chi nhánh"
            ),
            'attributes' => array(
                'title' => 'Tên chi nhánh',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'dia_chi_kho',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Địa chỉ"
            ),
            'attributes' => array(
                'title' => 'Địa chỉ',
                'class' => 'form-control'
            )
        ));


        $this->add(array(
            'name' => 'sua_gia_xuat',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Sửa tất cả giá xuất theo tỉ lệ chiết khấu mới',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
            'attributes' => array(
                'title' => 'Sửa tất cả giá xuất theo tỉ lệ chiết khấu mới',
            )
        ));
    }
}
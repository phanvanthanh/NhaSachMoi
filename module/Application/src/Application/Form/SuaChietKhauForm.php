<?php
namespace Application\Form;

use Zend\Form\Form;
/*
    sử dụng trong Application/Controller/HangHoaController themSanPhamAction
*/
class SuaChietKhauForm extends Form
{

    public function __construct()
    {
        parent::__construct("sua_chiet_khau");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id_kenh_phan_phoi',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => "Id kênh phân phối"
            ),
            'attributes' => array(
                'title' => 'Id kênh phân phối',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'chiet_khau_xuong',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Chiết khấu xuống"
            ),
            'attributes' => array(
                'title' => 'Chiết khấu xuống',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'chiet_khau_len',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Chiết khấu lên"
            ),
            'attributes' => array(
                'title' => 'Chiết khấu lên',
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
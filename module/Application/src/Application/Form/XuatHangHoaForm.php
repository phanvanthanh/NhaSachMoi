<?php
namespace Application\Form;

use Zend\Form\Form;
/*
    sử dụng trong Application/Controller/HangHoaController themSanPhamAction
*/
class XuatHangHoaForm extends Form
{

    public function __construct()
    {
        parent::__construct("xuat_hang_hoa");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id_khach_hang',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Id khách hàng"
            ),
            'attributes' => array(
                'title' => 'Id khách hàng',
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

        $this->add(array(
            'name' => 'gia_xuat',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Giá xuất"
            ),
            'attributes' => array(
                'title' => 'Giá xuất',
                'class' => 'form-control'
            )
        ));

        
    }
}
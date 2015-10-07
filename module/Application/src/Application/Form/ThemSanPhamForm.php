<?php
namespace Application\Form;

use Zend\Form\Form;

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
    }
}
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
    }
}
<?php
namespace Application\Form;

use Zend\Form\Form;

class LapPhieuChiForm extends Form
{

    public function __construct()
    {
        parent::__construct("lap_phieu_chi");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id_nha_cung_cap',
            'type' => 'Zend\Form\Element\Hidden',             
        )); 

        $this->add(array(
            'name' => 'ho_ten',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Họ tên nhà cung cấp',
                'class' => 'form-control',
                'id'    => 'ho_ten',
            ),
            'options' => array(
                'label' => "Họ tên nhà cung cấp"
            ),
        ));

        $this->add(array(
            'name' => 'ly_do',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Lý do',
                'class' => 'form-control',
                'id'    => 'ly_do',
            ),
            'options' => array(
                'label' => "Lý do"
            ),
        ));

        $this->add(array(
            'name' => 'so_tien',
            'type' => 'Zend\Form\Element\Number', 
            'attributes' => array(
                'title' => 'Số tiền thanh toán',
                'class' => 'form-control',
                'id'    => 'so_tien',
            ),
            'options' => array(
                'label' => "Số tiền thanh toán"
            ),
        ));
        
    }
}
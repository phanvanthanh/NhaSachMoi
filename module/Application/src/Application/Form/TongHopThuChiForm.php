<?php
namespace Application\Form;

use Zend\Form\Form;

class TongHopThuChiForm extends Form
{

    public function __construct()
    {
        parent::__construct("tong_hop_thu_chi");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'thoi_gian_bat_dau',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Thời gian bắt đầu',
                'class' => 'form-control date-time',
                'id'    => 'thoi_gian_bat_dau',
            ),
            'options' => array(
                'label' => "Thời gian bắt đầu"
            ),
        )); 

        $this->add(array(
            'name' => 'thoi_gian_ket_thuc',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Thời gian kết thúc',
                'class' => 'form-control date-time',
                'id'    => 'thoi_gian_ket_thuc',
            ),
            'options' => array(
                'label' => "Thời gian kết thúc"
            ),
        ));
        
    }
}
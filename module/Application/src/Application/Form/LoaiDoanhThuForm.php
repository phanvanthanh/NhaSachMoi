<?php
namespace Application\Form;

use Zend\Form\Form;

class LoaiDoanhThuForm extends Form
{

    public function __construct()
    {
        parent::__construct("loai_doanh_thu");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'loai_doanh_thu',
            'options' => array(
                'label' => 'Doanh thu',
                'value_options' => array(
                    'ngay' => 'Doanh thu theo ngày',
                    'thang' => 'Doanh thu theo tháng',
                    'nam' => 'Doanh thu theo năm',
                ),
            ),
            'attributes' => array(
                'title' => 'Loại doanh thu',
                'class' => 'form-control'
            )
        ));

        
    }
}
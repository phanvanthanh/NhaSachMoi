<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class TongHopThuChiFormFilter extends InputFilter
{

    public function __construct()
    {    
        $this->add(array(
            'name' => 'thoi_gian_bat_dau',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )       
        ));

        $this->add(array(
            'name' => 'thoi_gian_ket_thuc',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )       
        ));
        
    }
}

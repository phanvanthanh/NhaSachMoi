<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class LapPhieuChiFormFilter extends InputFilter
{

    public function __construct()
    {    
        $this->add(array(
            'name' => 'id_khach_hang',
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
            'name' => 'ho_ten',
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
            'name' => 'ly_do',
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
            'name' => 'so_tien',
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

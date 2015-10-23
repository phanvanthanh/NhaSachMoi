<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class TaoChiNhanhFormFilter extends InputFilter
{

    public function __construct()
    {   
        $this->add(array(
            'name' => 'ten_kho',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),                    
        ));

        $this->add(array(
            'name' => 'dia_chi_kho',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),                    
        ));
        
    }
}

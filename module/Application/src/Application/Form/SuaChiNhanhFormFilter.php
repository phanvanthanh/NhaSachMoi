<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class SuaChiNhanhFormFilter extends InputFilter
{

    public function __construct()
    {   
        $this->add(array(
            'name' => 'id_kho',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'Between',
                    'options' => array(
                        'min' => 1
                    ),
                ),
            ),        
        ));

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

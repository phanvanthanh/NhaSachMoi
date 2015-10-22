<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class SuaChietKhauFormFilter extends InputFilter
{

    public function __construct()
    {    
        $this->add(array(
            'name' => 'id_kenh_phan_phoi',
            'required' => true,
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
            'name' => 'chiet_khau_xuong',
            'required' => true,
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
                        'min' => 0
                    ),
                ),
            ),        
        ));

        $this->add(array(
            'name' => 'chiet_khau_len',
            'required' => true,
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
                        'min' => 0
                    ),
                ),
            ),        
        ));

        $this->add(array(
            'name' => 'sua_gia_xuat',
            'required' => true,
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
                        'min' => 0,
                        'max' => 1
                    ),
                ),
            ),        
        ));

        
    }
}

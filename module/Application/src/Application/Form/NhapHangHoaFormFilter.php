<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class NhapHangHoaFormFilter extends InputFilter
{

    public function __construct()
    {    
        $this->add(array(
            'name' => 'id_nha_cung_cap',
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
            'name' => 'id_san_pham',
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
            'name' => 'so_luong',
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
            'name' => 'gia_nhap',
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
    }
}

<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class ThemSanPhamFormFilter extends InputFilter
{

    public function __construct()
    {
    	$this->add(array(
            'name' => 'id_don_vi_tinh',
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
            'name' => 'ma_san_pham',
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
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 32
                    )
                )
            )
        ));
    }
}

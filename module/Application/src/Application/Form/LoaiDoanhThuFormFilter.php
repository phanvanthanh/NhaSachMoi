<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class LoaiDoanhThuFormFilter extends InputFilter
{

    public function __construct()
    {    
        $this->add(array(
            'name' => 'loai_doanh_thu',
            'required' => false,
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

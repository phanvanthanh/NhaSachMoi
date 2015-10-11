<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class SuaThongTinKhachHangFormFilter extends InputFilter
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
            ),
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
            ),
        ));

        $this->add(array(
            'name' => 'dia_chi',
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
            'name' => 'email',
            'required' => false,
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
            'name' => 'mo_ta',
            'required' => false,
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
            'name' => 'dien_thoai_co_dinh',
            'required' => false,
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
            'name' => 'di_dong',
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
            'name' => 'hinh_anh',
            'required' => false,
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

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
            'name' => 'ma_vach',
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
            'name' => 'id_loai_san_pham',
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
            'name' => 'ten_san_pham',
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

        $this->add(array(
            'name' => 'nhan',
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
            'name' => 'loai_gia',
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
                        'min' => 0
                    ),
                ),
            ),        
        ));

        $this->add(array(
            'name' => 'gia_bia',
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
                        'min' => 0
                    ),
                ),
            ),        
        ));

        $this->add(array(
            'name' => 'chiet_khau',
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
                        'min' => 0
                    ),
                ),
            ),        
        ));
    }
}

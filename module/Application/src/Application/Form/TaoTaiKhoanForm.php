<?php
namespace Application\Form;

use Zend\Form\Form;

class TaoTaiKhoanForm extends Form
{

    public function __construct()
    {
        parent::__construct("tao-tai-khoan");
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Tên đăng nhập"
            ),
            'attributes' => array(
                'title' => 'Tên đăng nhập',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => "Mật khẩu"
            ),
            'attributes' => array(
                'title' => 'Mật khẩu',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'ho_ten',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Họ tên"
            ),
            'attributes' => array(
                'title' => 'Họ tên',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'dia_chi',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Địa chỉ"
            ),
            'attributes' => array(
                'title' => 'Địa chỉ',
                'class' => 'form-control'
            )
        ));

        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => "Email"
            ),
            'attributes' => array(
                'title' => 'Email',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'mo_ta',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => "Mô tả"
            ),
            'attributes' => array(
                'title' => 'Mô tả',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'dien_thoai_co_dinh',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Điện thoại cố định"
            ),
            'attributes' => array(
                'title' => 'Điện thoại cố định',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'di_dong',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => "Điện thoại"
            ),
            'attributes' => array(
                'title' => 'Điện thoại',
                'class' => 'form-control'
            )
        ));

        
        $this->add(array(
            'name' => 'hinh_anh',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => "Hình ảnh"
            ),
            'attributes' => array(
                'title' => 'Hình ảnh',
                'class' => ''
            )
        ));
        
    }
}
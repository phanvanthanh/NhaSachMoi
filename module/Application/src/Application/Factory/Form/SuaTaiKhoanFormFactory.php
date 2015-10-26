<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaTaiKhoanForm;
use Application\Form\SuaTaiKhoanFormFilter;

class SuaTaiKhoanFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaTaiKhoanForm(); 
        $kho_table=$serviceLocator->get('Application\Model\KhoTable');
        $danh_sach_kho=$kho_table->getKho();
        
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_kho',
            'options' => array(
                'label' => 'Kho',
                'empty_option' => '-----Chọn-----',
                'value_options' => $danh_sach_kho,
            ),
            'attributes'    => array(
                'class' => 'form-control'
            ),
        ));

        $role_table=$serviceLocator->get('Permission\Model\JosAdminRoleTable');
        $danh_sach_role=$role_table->getRole();
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role_id',
            'options' => array(
                'label' => 'Chọn quyền',
                'empty_option' => '-----Chọn-----',
                'value_options' => $danh_sach_role,
            ),
            'attributes'    => array(
                'class' => 'form-control'
            ),
        ));

        $form->setInputFilter(new SuaTaiKhoanFormFilter());
        
        return $form;
    }
}
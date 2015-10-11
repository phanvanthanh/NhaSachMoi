<?php
namespace Application\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\SuaThongTinKhachHangForm;
use Application\Form\SuaThongTinKhachHangFormFilter;

class SuaThongTinKhachHangFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new SuaThongTinKhachHangForm(); 
        $storage=$serviceLocator->get('AuthService')->getStorage();
        $read=$storage->read();
        $id_kho=$read['id_kho'];        

        $kenh_phan_phoi_value_options=array();
        $kenh_phan_phoi_table=$serviceLocator->get('Application\Model\KenhPhanPhoiTable');
        $kenh_phan_phoi_value_options=$kenh_phan_phoi_table->getKenhPhanPhoiByIdKho($id_kho);
        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_kenh_phan_phoi',
            'options' => array(
                'label' => 'Kênh phân phối',
                'empty_option' => '-----Chọn-----',
                'value_options' => $kenh_phan_phoi_value_options,
            ),
            'attributes'    => array(
                'class' => 'form-control'
            ),
        ));
        
        $form->setInputFilter(new SuaThongTinKhachHangFormFilter());
        
        return $form;
    }
}
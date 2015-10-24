<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(  
                // navigation              
                'Navigation' => 'Application\Navigation\MyNavigationFactory',
                'NavigationRight' => 'Application\Navigation\MyNavigationRightFactory',
                // model
                'Application\Model\SanPhamTable' => 'Application\Factory\Table\SanPhamTableFactory',
                'Application\Model\BarcodeTable' => 'Application\Factory\Table\BarcodeTableFactory',
                'Application\Model\CongNoKhachHangTable' => 'Application\Factory\Table\CongNoKhachHangTableFactory',
                'Application\Model\CongNoNhaCungCapTable' => 'Application\Factory\Table\CongNoNhaCungCapTableFactory',
                'Application\Model\CtHoaDonTable' => 'Application\Factory\Table\CtHoaDonTableFactory',
                'Application\Model\CtPhieuNhapTable' => 'Application\Factory\Table\CtPhieuNhapTableFactory',
                'Application\Model\DonViTinhTable' => 'Application\Factory\Table\DonViTinhTableFactory',
                'Application\Model\GiaXuatTable' => 'Application\Factory\Table\GiaXuatTableFactory',
                'Application\Model\HoaDonTable' => 'Application\Factory\Table\HoaDonTableFactory',
                'Application\Model\KenhPhanPhoiTable' => 'Application\Factory\Table\KenhPhanPhoiTableFactory',
                'Application\Model\KhachHangTable' => 'Application\Factory\Table\KhachHangTableFactory',
                'Application\Model\KhoTable' => 'Application\Factory\Table\KhoTableFactory',
                'Application\Model\LoaiSanPhamTable' => 'Application\Factory\Table\LoaiSanPhamTableFactory',
                'Application\Model\NhaCungCapTable' => 'Application\Factory\Table\NhaCungCapTableFactory',
                'Application\Model\PhieuChiTable' => 'Application\Factory\Table\PhieuChiTableFactory',
                'Application\Model\PhieuNhapTable' => 'Application\Factory\Table\PhieuNhapTableFactory',
                'Application\Model\PhieuThuTable' => 'Application\Factory\Table\PhieuThuTableFactory',
                // form
                'Application\Form\ThemSanPhamForm' => 'Application\Factory\Form\ThemSanPhamFormFactory',
                'Application\Form\SuaSanPhamForm' => 'Application\Factory\Form\SuaSanPhamFormFactory',
                'Application\Form\ThemKhachHangForm' => 'Application\Factory\Form\ThemKhachHangFormFactory',
                'Application\Form\SuaThongTinKhachHangForm' => 'Application\Factory\Form\SuaThongTinKhachHangFormFactory',
                'Application\Form\ThemNhaCungCapForm' => 'Application\Factory\Form\ThemNhaCungCapFormFactory',
                'Application\Form\SuaThongTinNhaCungCapForm' => 'Application\Factory\Form\SuaThongTinNhaCungCapFormFactory',
                'Application\Form\NhapHangHoaForm' => 'Application\Factory\Form\NhapHangHoaFormFactory',
                'Application\Form\XuatHangHoaForm' => 'Application\Factory\Form\XuatHangHoaFormFactory',
                'Application\Form\SuaChietKhauForm' => 'Application\Factory\Form\SuaChietKhauFormFactory',
                'Application\Form\TaoChiNhanhForm' => 'Application\Factory\Form\TaoChiNhanhFormFactory',
                'Application\Form\SuaChiNhanhForm' => 'Application\Factory\Form\SuaChiNhanhFormFactory',
                'Application\Form\LoaiDoanhThuForm' => 'Application\Factory\Form\LoaiDoanhThuFormFactory',
            )
            
        );
    }
}

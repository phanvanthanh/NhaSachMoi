<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'ban_hang' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ban-hang[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\BanHang',
                        'action' => 'index'
                    )
                )
            ),
            'chi_nhanh' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/chi-nhanh[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ChiNhanh',
                        'action' => 'index'
                    )
                )
            ),
            'chinh_sach' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/chinh-sach[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ChinhSach',
                        'action' => 'index'
                    )
                )
            ),
            'doi_tac' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/doi-tac[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\DoiTac',
                        'action' => 'index'
                    )
                )
            ),
            'hang_hoa' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/hang-hoa[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\HangHoa',
                        'action' => 'index'
                    )
                )
            ),
            'tai_khoan' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/tai-khoan[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\TaiKhoan',
                        'action' => 'index'
                    )
                )
            ),
            'thanh_toan' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/thanh-toan[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ThanhToan',
                        'action' => 'index'
                    )
                )
            ),
            'thong_bao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/thong-bao[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ThongBao',
                        'action' => 'index'
                    )
                )
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\HangHoa' => 'Application\Controller\HangHoaController',
            'Application\Controller\DoiTac' => 'Application\Controller\DoiTacController',
            'Application\Controller\ChinhSach' => 'Application\Controller\ChinhSachController',
            'Application\Controller\ThanhToan' => 'Application\Controller\ThanhToanController',
            'Application\Controller\BanHang' => 'Application\Controller\BanHangController',
            'Application\Controller\ChiNhanh' => 'Application\Controller\ChiNhanhController',
            'Application\Controller\TaiKhoan' => 'Application\Controller\TaiKhoanController',
            'Application\Controller\ThongBao' => 'Application\Controller\ThongBaoController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout_ajax'           => __DIR__ . '/../view/layout/ajax-layout.phtml',
            'layout/layout_default'           => __DIR__ . '/../view/layout/layout-default.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/partial/menu' => __DIR__ . '/../view/application/partial/menu.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Hàng hóa', 
                'title' => 'Hàng hóa', 
                'route' => 'hang_hoa',
                'id'=>'hang_hoa',
                'icon' => '<b class="glyphicon glyphicon-qrcode"></b>',
                'order' => 0
            ),              
            array(
                'label' => 'Đối tác', 
                'title' => 'Đối tác', 
                'route' => 'doi_tac',
                'id'=>'doi_tac',
                'icon' => '<b class="glyphicon glyphicon-signal"></b>',
                'order' => 1
            ),
            array(
                'label' => 'Chính sách', 
                'title' => 'Chính sách', 
                'route' => 'chinh_sach',
                'id'=>'chinh_sach',
                'icon' => '<b class="glyphicon glyphicon-scissors"></b>',
                'order' => 2
            ),  
            array(
                'label' => 'Thanh toán', 
                'title' => 'Thanh toán', 
                'route' => 'thanh_toan',
                'id'=>'thanh_toan',
                'icon' => '<b class="glyphicon glyphicon-usd"></b>',
                'order' => 3
            ), 
            array(
                'label' => 'Bán hàng', 
                'title' => 'Bán hàng', 
                'route' => 'ban_hang',
                'id'=>'ban_hang',
                'icon' => '<b class="glyphicon glyphicon-shopping-cart"></b>',
                'order' => 4
            ),  
            array(
                'label' => 'Chi nhánh', 
                'title' => 'Chi nhánh', 
                'route' => 'chi_nhanh',
                'id'=>'chi_nhanh',
                'icon' => '<b class="fa fa-share-alt"></b>',
                'order' => 5
            ),
            array(
                'label' => 'Thông báo', 
                'title' => 'Thông báo', 
                'route' => 'thong_bao',
                'id'=>'thong_bao',
                'icon' => '<b class="fa fa-bell shake"></b>',
                'order' => 6
            ),
            array(
                'label' => 'Tài khoản', 
                'title' => 'Tài khoản', 
                'route' => 'tai_khoan',
                'id'=>'tai_khoan',
                'icon' => '<i class="fa fa-user fa-lg"></i>',
                'order' => 7
            ),
                  
        ),
    ),
);

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
    'controller_plugins' => array(
        'invokables' => array(
            'barcode' => 'Application\Controller\Plugin\Barcode', 
        ),
        'shared'=>array(
            'barcode'=>false,
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
            'application/partial/menu_right' => __DIR__ . '/../view/application/partial/menu-right.phtml',
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
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="glyphicon glyphicon-qrcode"></b>',
                'order' => 0,                
            ),              
            array(
                'label' => 'Đối tác', 
                'title' => 'Đối tác', 
                'route' => 'doi_tac',
                'id'=>'doi_tac',
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="glyphicon glyphicon-signal"></b>',
                'order' => 1
            ),
            array(
                'label' => 'Chính sách', 
                'title' => 'Chính sách', 
                'route' => 'chinh_sach',
                'id'=>'chinh_sach',
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="glyphicon glyphicon-scissors"></b>',
                'order' => 2
            ),  
            array(
                'label' => 'Thanh toán', 
                'title' => 'Thanh toán', 
                'route' => 'thanh_toan',
                'id'=>'thanh_toan',
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="glyphicon glyphicon-usd"></b>',
                'order' => 3
            ), 
            array(
                'label' => 'Bán hàng', 
                'title' => 'Bán hàng', 
                'route' => 'ban_hang',
                'id'=>'ban_hang',
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="glyphicon glyphicon-shopping-cart"></b>',
                'order' => 4
            ),  
            array(
                'label' => 'Chi nhánh', 
                'title' => 'Chi nhánh', 
                'route' => 'chi_nhanh',
                'id'=>'chi_nhanh',
                'class' => '',
                'attr'  => '',
                'sub_class' => '',
                'sub_attr'  => '',
                'icon' => '<b class="fa fa-share-alt"></b>',
                'order' => 5
            ),
            array(
                'label' => 'Thông báo', 
                'title' => 'Thông báo', 
                'route' => 'thong_bao',
                'id'=>'thong_bao',
                'class' => 'dropdown',
                'attr'  => '',
                'sub_class' => 'dropdown-toggle',
                'sub_attr'  => 'data-toggle="dropdown"',
                'icon' => '<b class="fa fa-bell shake"></b>',
                'order' => 6
            ),
            array(
                'label' => 'Tài khoản', 
                'title' => 'Tài khoản', 
                'route' => 'tai_khoan',
                'id'    =>'tai_khoan',
                'class' => 'dropdown',
                'attr'  => '',
                'sub_class' => 'dropdown-toggle',
                'sub_attr'  => 'data-toggle="dropdown"',
                'icon' => '<i class="fa fa-user fa-lg"></i>',
                'order' => 7,
                'pages' => array(
                    array(
                        'label' => 'Quản lý tài khoản', 
                        'title' => 'Quản lý tài khoản', 
                        'route' => '/tai-khoan',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 2
                    ),
                    array(
                        'label' => 'Thoát', 
                        'title' => 'Thoát', 
                        'route' => '/permission/permission/logout',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                ),
            ),
                  
        ),
    ),

    'navigation_right' => array(
        'default' => array(
            array(
                'route' => 'hang_hoa',
                'pages' => array(
                    array(
                        'label' => ' Danh sách sản phẩm', 
                        'title' => ' Danh sách sản phẩm', 
                        'route' => '/hang-hoa',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),

                    array(
                        'label' => ' Bảng giá', 
                        'title' => ' Bảng giá', 
                        'route' => '/hang-hoa/bang-gia',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                    
                    
                    array(
                        'label' => ' Nhập hàng', 
                        'title' => ' Nhập hàng', 
                        'route' => '/hang-hoa/nhap-hang',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                    array(
                        'label' => ' Xuất hàng', 
                        'title' => ' Xuất hàng', 
                        'route' => '/hang-hoa/xuat-hang',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                    array(
                        'label' => ' Đổi trả hàng', 
                        'title' => ' Đổi trả hàng', 
                        'route' => '/hang-hoa/doi-tra-hang',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                ),
            ),

            array(
                'route' => 'doi_tac',
                'pages' => array(
                    array(
                        'label' => ' Khách hàng', 
                        'title' => ' Khách hàng', 
                        'route' => '/doi-tac/khach-hang',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),  
                    array(
                        'label' => ' Nhà cung cấp', 
                        'title' => ' Nhà cung cấp', 
                        'route' => '/doi-tac/nha-cung-cap',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                   
                ),
            ),

            array(
                'route' => 'chinh_sach',
                'pages' => array(
                    array(
                        'label' => ' Chính sách', 
                        'title' => ' Chính sách', 
                        'route' => '/chinh-sach',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                  
                ),
            ),

            array(
                'route' => 'chi_nhanh',
                'pages' => array(
                    array(
                        'label' => ' Chi nhánh', 
                        'title' => ' Chi nhánh', 
                        'route' => '/chi-nhanh',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                  
                ),
            ),

            array(
                'route' => 'thanh_toan',
                'pages' => array(
                    array(
                        'label' => ' Tổng hợp thu chi', 
                        'title' => ' Tổng hợp thu chi', 
                        'route' => '/thanh-toan/tong-hop-thu-chi',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ), 
                    array(
                        'label' => ' Khách hàng', 
                        'title' => ' Khách hàng', 
                        'route' => '/thanh-toan/khach-hang',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),   
                    array(
                        'label' => ' Nhà cung cấp', 
                        'title' => ' Nhà cung cấp', 
                        'route' => '/thanh-toan/nha-cung-cap',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),  
                    array(
                        'label' => ' Phiếu thu', 
                        'title' => ' Phiếu thu', 
                        'route' => '/thanh-toan/phieu-thu',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                    array(
                        'label' => ' Phiếu chi', 
                        'title' => ' Phiếu chi', 
                        'route' => '/thanh-toan/phieu-chi',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                 
                ),
            ),

            array(
                'route' => 'ban_hang',
                'pages' => array(
                    array(
                        'label' => ' Doanh thu', 
                        'title' => ' Doanh thu', 
                        'route' => '/ban-hang/doanh-thu',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),  
                    array(
                        'label' => ' Phiếu xuất', 
                        'title' => ' phiếu xuất', 
                        'route' => '/ban-hang/phieu-xuat',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),
                    array(
                        'label' => ' Phiếu nhập', 
                        'title' => ' Phiếu nhập', 
                        'route' => '/ban-hang/phieu-nhap',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                              
                ),
            ),
            array(
                'route' => 'tai_khoan',
                'pages' => array(
                    array(
                        'label' => ' Danh sách tài khoản', 
                        'title' => ' Danh sách tài khoản', 
                        'route' => '/tai-khoan',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),  
                    // array(
                    //     'label' => ' Thoát', 
                    //     'title' => ' Thoát', 
                    //     'route' => '/permission/permission/logout',
                    //     'id'=>'#',
                    //     'icon' => '',
                    //     'order' => 1
                    // ),                              
                ),
            ),
            array(
                'route' => 'permission/permission',
                'pages' => array(
                    array(
                        'label' => ' Phân quyền', 
                        'title' => ' Phân quyền', 
                        'route' => '/permission/permission/index',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),  
                    array(
                        'label' => ' Sửa quyền', 
                        'title' => ' Sửa quyền', 
                        'route' => '/permission/permission/edit',
                        'id'=>'#',
                        'icon' => '',
                        'order' => 1
                    ),                              
                ),
            ),
                  
        ),
    ),
);

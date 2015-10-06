<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Permission\Controller\Permission' => 'Permission\Controller\PermissionController'
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),

    'controller_plugins' => array(
        'invokables' => array(
            'tree_plugin' => 'Permission\Controller\Plugin\TreePlugin', 
        ),
        'shared'=>array(
            'tree_plugin'=>false,
        ),
    ),
    'router' => array(
        'routes' => array(
            'permission' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/permission',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Permission\Controller',
                        'controller'    => 'Permission',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'permission' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/permission[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Permission\Controller\Permission',
                                'action' => 'login'
                            )
                        )
                    ),
                ),
            ),
        ),
    ),

    
  
);
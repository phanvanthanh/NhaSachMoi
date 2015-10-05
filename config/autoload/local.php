<?php
return array(
	'service_manager' =>array (
        'factories' =>array (
          		'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),    
    'db' =>array (
        'driver' => 'pdo',
        'dsn' => 'mysql:dbname=nha_sach;host=localhost',
        'username' => 'root',
        'password' => '',
        'driver_options' =>array (
          		1002 => 'SET NAMES \'UTF8\'',
        ),
    ),
);

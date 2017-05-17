<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'a2' => array(
		'resources' => array(
			'basket_element_controller' => 'module_controller',
			'basket_list_controller' => 'module_controller',
			'basket' => 'module',
		),
		'rules' => array(
			'allow' => array(
				'controller_access_1' => array(
					'role' => 'main',
					'resource' => 'basket_element_controller',
					'privilege' => 'access',
				),
				'basket_edit_1' => array(
					'role' => 'main',
					'resource' => 'basket',
					'privilege' => 'edit',
				),
				
				
				
				'controller_access_2' => array(
					'role' => 'main',
					'resource' => 'basket_list_controller',
					'privilege' => 'access',
				),
			),
			'deny' => array(
			)
		)
	),
);
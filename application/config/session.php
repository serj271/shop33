<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'native'=>array(
	    'name'=>'session_name',
	    'lifetime'=>43200,
	),
	'cookie' => array(
	    'name'=>'cookie_name',
	    'encrypted' => TRUE,
	    'lifetime'=>604800,
	),
	'database'=>array(
	    'name'=>'cookie_name',
	    'encrypted'=>TRUE,
	    'lifetime'=>DATE::HOUR,
	    'group'=>'default',
	    'table'=>'sessions',
	    'columns'=>array(
		'session_id'=>'session_id',
		'last_active'=>'last_active',
		'contents'=>'contents',	
	    ),
	    'gc'=>500
	),
);

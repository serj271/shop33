<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'username' =>array(	
		'not_empty'     => ':field must not be empty',	
		'unique'	=> ':field not unique',
    ),
    'password_confirm' => array(
		'matches' => 'The password fields did not match.',
    ),
    'password'=>array(
		'not_empty' => ':field must not be empty',
    ),
    'email'=>array(
		'unique'	=>':field not unique',    
    ),
    
);

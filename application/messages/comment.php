<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'not_empty' => "Yo dawg, this field can't be empty!",
    'Validation::lt' => "[other message]",
    'text'=>array(
	'not_empty'=>':field must not be empty'
    ),
    'state'=> array(
	'in_array_'=>":field :value in not array",
    ),
	'comment'=>array('token'=>array(
		'Security::check'=>'token error'
	)),
);
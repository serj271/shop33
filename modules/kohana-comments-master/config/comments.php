<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'default' => array(
		'model'       => 'Comment',
		'per_page'    => 2,
		'view'        => 'comments',
		'lower_limit' => 0.2,
		'upper_limit' => 0.9,
		'order'       => 'DESC',
	),
);


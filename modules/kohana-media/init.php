<?php defined('SYSPATH') or die('No direct script access.');

Route::set('media', 'media/(<uid>/)<filepath>', array(
		'filepath' => '.*', // Pattern to match the file path
		'uid' => '.*?',     // Match the unique string that is not part of the media file
	))
	->defaults(array(
		'controller' => 'Media',
		'action'     => 'serve',
	));
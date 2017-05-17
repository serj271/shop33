<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Help_Info extends Controller_Common {
    public $template='main';
	public function action_index() {

//	echo 'info';
	echo Route::url('info', array('controller'=>'info','action'=>'index'));



	}
} // End 

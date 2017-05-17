<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller {
	public function action_index(){	
//	    $this->response->body->('test');
	    Log::instance()->add(Log::NOTICE, Debug::vars($this->request));
	    echo 'test33';
	}
} // End Welcome


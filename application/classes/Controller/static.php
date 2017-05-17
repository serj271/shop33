<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static extends Controller {
	protected $_model = 'catalog_category';
	
	
	public function action_index(){	
		
//		Log::instance()->add(Log::NOTICE, 'My Logged Message Here');
//	$renderer = Kostache::factory(); 
		$this->response->body('hello, world static!');	
		
//		$pagination  = new Pagination::$factory();
//		$this->response->body('hello, world!');
//		$this->response->body($renderer->render(new View_Test)); 
//	    $internal_request=View::factory('welcome');

	}
	
	public function action_detail(){	
		
//		Log::instance()->add(Log::NOTICE, 'My Logged Message Here');
//	$renderer = Kostache::factory(); 
		$this->response->body('hello, world catalog! detail');	
		
//		$pagination  = new Pagination::$factory();
//		$this->response->body('hello, world!');
//		$this->response->body($renderer->render(new View_Test)); 
//	    $internal_request=View::factory('welcome');

	}
} // End Controller_Catalog


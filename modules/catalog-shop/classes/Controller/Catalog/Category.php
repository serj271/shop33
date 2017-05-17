<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Catalog_Category extends Controller_Catalog {
	protected $_model = 'catalog_category';
	

	public function action_index(){	
		$request = $this->request->current();
		$query_controller = $request->query('controller');		
		$param = $this->request->param('category_uri');
//		Log::instance()->add(Log::NOTICE, Debug::vars($param));
//		$brearcrBreadcrumb = Breadcrumb::factory()->set_title("Added Crumb")->set_url("http://example.com/");
//		Log::instance()->add(Log::NOTICE, Debug::vars($brearcrBreadcrumb->get_title()));
//		Breadcrumbs::add(array('title','http://ee.t'));
		Breadcrumbs::add(array('home','/shop33/'));
		Breadcrumbs::generate_from_request($this->request);
//		$this->view->breadcrumbs = Breadcrumbs::get();
//		Log::instance()->add(Log::NOTICE, Debug::vars(Breadcrumbs::get()));
		$breadcrumbs = array();
		foreach (Breadcrumbs::get() as $breadcrumb){
			$breadcrumbs[] = array('title'=>$breadcrumb->get_title(),'url'=>$breadcrumb->get_url());			
		}
		Log::instance()->add(Log::NOTICE, Debug::vars($breadcrumbs,Breadcrumbs::render()));
//		$this->view->breadcrumbs = Breadcrumbs::render();
		$this->view->countBreadcrumbs = count($breadcrumbs);
		$sep = Kohana::$config->load('breadcrumbs.separator');
		$this->view->sep = $sep;
		$this->template->breadcrumbs = Breadcrumbs::render();
//		$this->template->content = Breadcrumbs::render();
//    	Breadcrumbs::add(Breadcrumb::factory()->set_title("Added Crumb")->set_url("http://example.com/"));
		
//	$renderer = Kostache::factory(); 
//		$this->response->body('hello, world catalog category!');	
		
//		$pagination  = new Pagination::$factory();
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


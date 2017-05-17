<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {
	public function action_index(){	
//		Log::instance()->add(Log::NOTICE, 'My Logged Message Here');
//	$renderer = Kostache::factory(); 
//		$this->response->body('hello, world!');		
//		$pagination  = new Pagination::$factory();
//		$this->response->body('hello, world!');
//		$this->response->body($renderer->render(new View_Test)); 
//	    $internal_request=View::factory('welcome');
	    $current_route = $this->request->route();
	    $controller = $this->request->controller(); //welcome
	    $action = $this->request->action(); //index
	    $ip = Request::$client_ip;
	    $referer = Request::initial()->referrer(); 
//	    $user_agent = Request::user_agent($value);//browser, version,robot,mobile,platform
//	system/config/user_agents.php
//	    Log::instance()->add(Log::NOTICE, var_dump(Request::user_agent(array('browser','platform','version','mobile','robot'))));
	    print('</br>');
	    print_r(request::accept_type());
	
	    print_r(request::accept_lang());
	    print_r(request::accept_encoding());
	    print('</br>');
//	    print(Kohana::$is_cli);
	    $array = array('track'=>123);
	    echo Debug::vars($array);
	    echo Debug::source(__FILE__, __LINE__,3);
	    echo Debug::path('/usr/local/www/kohana/application/config/auth.php');
	    echo '</br>';
//	    $internal_request = Request::factory('welcome/widget')
//		->execute()->body();
//	    $this->response->body($internal_request.' from action_index'.
//	    '</br>'.'acton_index: '.$this->request->uri().'  test home');		
	    $view = View::factory('welcome');
	    $welcome = (string) $view->render();
	    echo $welcome;
	    echo '</br>';
	    echo Kohana::$environment;
	    echo '</br>';
//	    Log::instance()->add(Log::NOTICE, Debug::vars($this->request->route()->uri()));
//	    Log::instance()->add(Log::NOTICE, Debug::vars($this->request->controller())); //directory action
//	    echo error_reporting(E_ALL);
//	    throw HTTP_Exception::factory(404,'File not found');
		$route_name = Route::name($this->request->route());
		echo $route_name;
//		throw HTTP_Exception::factory(404, 'Product not found!');
//		$this->redirect('catalog', 303);
//		HTTP::redirect('/user');
#		$request = Request::factory('error/500');
#		$response = $request->execute();
		echo Helpers_Media::alert();	

	}
} // End home


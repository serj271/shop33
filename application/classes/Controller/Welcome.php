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
		Log::instance()->add(Log::NOTICE, 'okii');		
		$filepath = $this->request->param('filepath');
		$uid = $this->request->param('uid');

		$cfs_file = Kohana::find_file('media', $filepath, FALSE);
		Log::instance()->add(Log::NOTICE, Debug::vars($filepath, $cfs_file));




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
		echo "Current version is PHP " . phpversion();
		$crypt = Encrypt::instance();
		echo $crypt->decode($crypt->encode('55'));
		$string = "Some text to be encrypted";
		$secret_key = "1111111111111111";
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
		
		$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
		
		$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $encrypted_string, MCRYPT_MODE_CBC, $iv);
		echo $decrypted_string ;
		
		$iv = 'aa';
		echo "</br>";
		echo  substr(base64_decode(base64_encode($iv.'99')), 0 ,strlen($iv)).'</br>';
//		echo Debug::source(__FILE__, __LINE__);
    // Displays "APPPATH/cache" rather than the real path
		echo Debug::path(APPPATH.'cache');	
//		phpinfo();		
//		echo file_get_contents('/usr/local/www/shop33/media/css/common_v4.css');

	

	}
} // End home


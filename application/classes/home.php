<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Common_Home {
//    public $template ='main';
    public function action_index(){
//		$this->title = Kohana::$config->load('personal.personal.title');	    
//	Kohana::message('forms','foobar');
//            throw new Kohana_Exception('That user does not exist.', NULL, 404);
        $message = __("Hello, Guest");
		$session = Session::instance();
//		Message::set('success', __('Form was successfully submitted.'));
//		$key='id_user';
//		$value="1018";
//		$session->set($key, $value);
//	$message = __('Hello, :user', array(':user'=>$username));
//	$message = $_SERVER['HTTP_HOST'];
//	$message = Debug::source(__FILE__, __LINE__);
//	$message = Debug::vars($username);
//	$data = 'test';
//	Cookie::set('test', $data);
//	Cookie::encrypt('test', $data);
//	$encrypt = Encrypt::instance('default');	
	
//	Kohana::$environment = Kohana::PRODUCTION;//10
//	Kohana::$environment = Kohana::DEVELOPMENT;//40
//	$message = Kohana::$environment;	    
//	$message = Kohana::$environment;

        $content = View::factory('/home/content');
        $this->template->content=$this->title;
        $navigator=View::factory('/home/navigator')
    	    ->set('message',$message);
        $this->template->navigator=$navigator;
//		Kohana::auto_load('Kostache');
//		$renderer = Kostache::factory(); 
//				list($view_name, $view_path) = static::find_view($this->request);
//				Log::instance()->add(Log::NOTICE,$view_name);
//				if (Kohana::find_file('classes', $view_path))
//				{		
					
//				}
		
#		$headermenu = new View_headermenu_index(); 
		
#		$menu = $renderer->render($headermenu);		
//		$menu = View::factory('/personal/menu')
//			->set('lang',$lang);
		
#		$this->template->menu = $menu;		    


		    
    }



    
    public function action_contacts(){

    }

} // End 

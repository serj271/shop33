<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Product_Main extends Controller_Product {
//    public $template ='main';
    protected $_model='user';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
	
		
		$this->view = 'f';
		
//	Log::instance()->add(Log::NOTICE,Debug::vars(Auth::instance()->get_user_roles()));
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
} // End 

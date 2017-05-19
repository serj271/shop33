<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Basket_Main extends Controller_Basket_Crud {
//    public $template ='main';
	public $_model='Shopping_Cart';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
//		if (!Auth::instance()->logged_in('login')){
//		
//			$this->redirect('user/auth/login');
//		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
		
		
		
//	Log::instance()->add(Log::NOTICE,Debug::vars(Auth::instance()->get_user_roles()));
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
//		$order_by = $this->request->param('pole','id');
		$count = ORM::factory($this->_model)->count_all();
/* 		$pagination = Pagination::factory(array(
			'items_per_page'=> 10,
			'total_items' 	=> $count,
		))->route_params(array(
			'directory' 	=> $this->request->directory(),
			'controller' 	=> $this->request->controller(),
			'action'		=> $this->request->action(),
			'pole'			=>$order_by,
			'view'			=> 'pagination/bootstrap',
		));
		
		$items = ORM::factory($this->_model)
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by($order_by)
			->find_all(); */
//		Log::instance()->add(Log::NOTICE,Debug::vars($items));
		// Pass to view
		$items = ORM::factory($this->_model)
//			->limit($pagination->items_per_page)
//			->offset($pagination->offset)
//			->order_by($order_by)
			->find_all();
		$this->view->items 		= $items;
//		$this->view->pagination = $pagination;
//		Log::instance()->add(Log::NOTICE,Debug::vars(Debug::vars('------',$items)));



		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
	public function action_add(){
		
		
		
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
	
	
} // End 

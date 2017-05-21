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
/* 		$items = ORM::factory($this->_model)
			->find_all(); */
		$cart = Cart::instance();
		$cart_model = ORM::factory($this->_model,1);
		$cart_id = $cart_model->cart_id;
		$items = $cart->shopping_cart_get_products($cart_id);	
			
		$this->view->items 		= $items;
		
		Cart::SetCartId();
		$cartId = Cart::GetCartId();
		
//		Log::instance()->add(Log::NOTICE,Debug::vars($cartId ));
		/* $cart = Cart::instance();
		$cart_model = ORM::factory($this->_model,2);
		$cart_id = $cart_model->cart_id;
		$carts = $cart->shopping_cart_get_products($cart_id);
		$result = $cart->shopping_cart_get_total_amount($cart_id);
		foreach ($carts as $item){
				Log::instance()->add(Log::NOTICE,Debug::vars('cart--',$result,$cart_id,$item));
			
		} */
//		Log::instance()->add(Log::NOTICE,Debug::vars('cart--',$result->as_array(),$cart_id));
//		$this->view->pagination = $pagination;
//		Log::instance()->add(Log::NOTICE,Debug::vars(Debug::vars('------',$items)));



		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
	public function action_add(){
		$item = ORM::factory('Product', $this->request->param('id'));
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
		}
		
		if ($this->request->method() === Request::POST)
		{
			$action = $this->request->post('action');
			
			if ($action !== 'yes')
			{
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));
			}
//			$cart = Cart::instance();
//			$cart->addProduct($this->cart_id,$productId, $attributes);
			
		/* 	$item->delete();
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				))); */
		}
		
		$this->view->item = $item;

		
		
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
	
	
} // End 

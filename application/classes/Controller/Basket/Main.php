<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Basket_Main extends Controller_Basket_Crud {
//    public $template ='main';
	public $_model='Shopping_Cart';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
//		Session::instance('database');
//		if (!Auth::instance()->logged_in('login')){
//		
//			$this->redirect('user/auth/login');
//		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;		
		$results = Cart::GetProducts($this->mCartId);
		$carts = array();
		
		foreach($results as $result){
			$carts[] =  $result;							
		}
		$results = Cart::GetTotalAmount($this->mCartId);
		$total_amount = $results[0]['total_amount'];
//		Log::instance()->add(Log::NOTICE, Debug::vars($carts,$this->mCartId));
		
		$this->view->carts = $carts;//id, cart_id, name from variontion, attributes, price, quantity, subtotal, uri 
		$this->view->items = $carts;//id, cart_id, name from variontion, attributes, price, quantity, subtotal, uri 
		$this->view->total_amount = $total_amount;
		
		
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

		// Pass to view
/* 		$items = ORM::factory($this->_model)
			->find_all(); */
		
//		$cart_model = ORM::factory($this->_model,1);
		/* $session = Session::instance('native');			
		Log::instance()->add(Log::NOTICE,Debug::vars($session->id()));	
		$mCartId = $session->get('mCartId', false);	
		if($mCartId){
			$items = Cart::GetProducts($mCartId);				
			$this->view->items 		= $items;			
		} */
//		$cart_id = Cart::GetCartId();
//		$items = Cart::GetProducts($cart_id);	
			
//		$this->view->items 		= $items;
		
//		Cart::SetCartId();
//		$cartId = Cart::GetCartId();
		

		/* $cart = Cart::instance();
		$cart_model = ORM::factory($this->_model,2);
		$cart_id = $cart_model->cart_id;
		$carts = $cart->shopping_cart_get_products($cart_id);
		$result = $cart->shopping_cart_get_total_amount($cart_id);
		foreach ($carts as $item){
				Log::instance()->add(Log::NOTICE,Debug::vars('cart--',$result,$cart_id,$item));
			
		} */

//		$this->view->pagination = $pagination;




		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
	/* public function action_add(){
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
			
			$item->delete();
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));
		}		
		$this->view->item = $item;		
		
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	} */
	
	public function action_delete(){//dlete product from basket
		$item = ORM::factory($this->_model, $this->request->param('id'));//cartId
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
		}
		
		if ($this->request->method() === Request::POST)
		{
			if($post = $this->request->post()){
				$post = array_map('trim', $post);
				$last_input = Arr::extract($post, array('action'), NULL);
				if($last_input['action'] == 'yes'){
//					Log::instance()->add(Log::NOTICE,Debug::vars('delete yes',$last_input,$this->request->param('id')));
					Cart::DeleteShoppingCart( $this->request->param('id'));
				}
			}
//			$this->redirect(strtolower($this->request->directory()),303);	
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),
					'action'		=>'index',
				)));	
		}		
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
	public function action_update()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
			
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			try
			{
				$item->values($this->request->post());
				$item->logins = 0;					
				$item->update($validation);
//				Log::instance()->add(Log::NOTICE, Debug::vars(Route::get('useradmin')));
//				$this->redirect('/');

				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
					'action'		=> 'read',
					'id'			=> $item->id,
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('validation');
			}
		}			
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
} // End 

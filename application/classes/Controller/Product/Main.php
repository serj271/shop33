<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Product_Main extends Controller_Product {
//    public $template ='main';
	protected $_model = 'Product';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		/* $cart = Cart::SetCartId();
		Log::instance()->add(Log::NOTICE,Debug::vars(Cart::GetCartId()));	 */
//		if (!Auth::instance()->logged_in('login')){		
//			$this->redirect('user/auth/login');
//		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
		$item_uri = $this->request->param('item_uri');
		$model = 'Product';
		$result = array();

		if($item_uri)
		{
			$products_orm = ORM::factory($model)
			->where('uri','=',$item_uri)
			->find_all();	
			foreach ($products_orm as $product){
				$products_as_array = $product->as_array();				
				$photo = $product->primary_photo()->as_array();
				$controller = $this->request->controller();
				$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
				$products_as_array['photo'] = $photo;
				$reviews = $product->reviews->find()->as_array();
				$specifications = $product->specifications->find()->as_array();
				$products_as_array['specifications'] = $specifications;
				$products_as_array['reviews'] = $reviews;
				$result[] = $products_as_array;	
			}
			$this->view->product = $result;
//						$content_view->product = $result;					
//						$content = $renderer->render($content_view);												
//						$this->template->content = $content;
						
//						Log::instance()->add(Log::NOTICE,Debug::vars('result----',$controller));						
		} else 
		{	

			$pagination = Pagination::factory(array(
				'items_per_page'=> 1,
				'total_items' 	=> 3,
			))->route_params(array(
				'directory' 	=> $this->request->directory(),
				'controller' 	=> $this->request->controller(),
				'action'		=> $this->request->action(),
				'pole'			=>'id',
				'view'			=> 'pagination/basic',
				));
				
			$products_orm = ORM::factory('Product')
				->limit($pagination->items_per_page)
				->offset($pagination->offset)
				->order_by('id')
				->find_all();
		
			foreach ($products_orm as $product){
				$products_as_array = $product->as_array();				
				$photo = $product->primary_photo()->as_array();
				$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
				$products_as_array['photo'] = $photo;
				$reviews = $product->reviews->find()->as_array();
				$specifications = $product->specifications->find()->as_array();
				$products_as_array['specifications'] = $specifications;
				$products_as_array['reviews'] = $reviews;
				$result[] = $products_as_array;	
			}
			$this->view->pagination = $pagination;
			$this->view->product = $result;
//			$this->view = $result;
//						Log::instance()->add(Log::NOTICE,Debug::vars('+++++++',$pagination->render()));
//						$content_view->product = $result;
//						$content_view->pagination = $pagination->render();
//						$content = $renderer->render($content_view);		
//											
//						$this->template->content = $content;
						
		} 
		

	
//		$this->view->test = 'Test ---';
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
//		$login = View::factory('user/menulogout');
//		$this->template->menu=$login;
    }
	
	public function action_read()
	{
		$item_uri = $this->request->param('item_uri');
		$item = ORM::factory($this->_model)
			->where('uri','=',$item_uri)
			->find();
			
	/* 	$cart = Cart::SetCartId();
		Log::instance()->add(Log::NOTICE,Debug::vars(Cart::GetCartId()));	 */
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));

			$lang = Lang::instance()->get();
			if($lang == 'ru'){
				I18n::lang('ru');	
			} else {
				I18n::lang('en-us');		
			}
		   /*  Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
		$this->view_navigator->message = __(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))); */
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),					
				)));

		}	

//		foreach ($products_orm as $product){
//			$products_as_array = $product->as_array();				
			/* $photo = $item->primary_photo()->as_array();
//			$controller = $this->request->controller();
			$array 	= $this->item->object();
			$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
			$array['photo'] = $photo; */
			
		/* 	$products_as_array['photo'] = $photo;
			$reviews = $product->reviews->find()->as_array();
			$specifications = $product->specifications->find()->as_array();
			$products_as_array['specifications'] = $specifications;
			$products_as_array['reviews'] = $reviews; */
			/* $result[//] = $products_as_array;	 */
//		}		

//		Log::instance()->add(Log::NOTICE,Debug::vars($photo));			
		$this->view->item = $item;
	/* 	$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))); */
	}
	
	public function action_create()
	{
		$item = ORM::factory($this->_model);

		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
			Log::instance()->add(Log::NOTICE,Debug::vars($this->request->post()));	
			$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				)));
			
			try
			{
			/* 	$item->values($this->request->post());
				$code = md5(uniqid(rand(),true));
				$code = substr($code,0,64);	    
				$item->one_password = $code;		
				$item->create($validation);
					
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				))); */
			}
			catch (ORM_Validation_Exception $e)
			{
				Log::instance()->add(Log::NOTICE, Debug::vars($e->errors('validation')));
				$this->view->errors = $e->errors('models/user');
			}
		}
//		Log::instance()->add(Log::NOTICE,Debug::vars($item));			
		$this->view->item = $item;
	}
	
	
	public static function addBase($url){
			return URL::base().$url;			
	} 
} // End 

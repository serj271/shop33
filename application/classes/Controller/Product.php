<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Product extends Controller_Common_Product {
//    public $template ='main';
    public function action_index(){
//		$this->title = Kohana::$config->load('personal.personal.title');	    
//	Kohana::message('forms','foobar');
//            throw new Kohana_Exception('That user does not exist.', NULL, 404);
        $message = __("Hello, Guest");
		$session = Session::instance();
//		Message::set('success', __('Form was successfully submitted.'));
//		$session->set($key, $value);
//	$message = __('Hello, :user', array(':user'=>$username));
//	$message = $_SERVER['HTTP_HOST'];
//	$message = Debug::source(__FILE__, __LINE__);
//	$message = Debug::vars($username);
//	Cookie::set('test', $data);
//	Cookie::encrypt('test', $data);
//	$encrypt = Encrypt::instance('default');	
	
//	Kohana::$environment = Kohana::PRODUCTION;//10
//	Kohana::$environment = Kohana::DEVELOPMENT;//40
//	$message = Kohana::$environment;	    
//	$message = Kohana::$environment;
	$item_uri = $this->request->param('item_uri');
	$model = 'Product';
	$result = array();	
        $content = View::factory('/home/content');
        $this->template->content=$content;
        $navigator=View::factory('/home/navigator')
    	    ->set('message',$message);
        $this->template->navigator=$navigator;
		Kohana::auto_load('Kostache');
		$renderer = Kostache::factory(); 
				list($view_name, $view_path) = static::find_view($this->request);
				//Log::instance()->add(Log::NOTICE,$view_name.$view_path);
				
				if (Kohana::find_file('classes', $view_path))
				{		
					$content_view = new $view_name();
//					Log::instance()->add(Log::NOTICE,$view_name.$view_path.'----------------'.$item_uri);

					if($item_uri){
						$products_orm = ORM::factory($model)
						->where('uri','=',$item_uri)
						->find_all();	
						foreach ($products_orm as $product){
							$products_as_array = $product->as_array();				
							$photo = $product->primary_photo()->as_array();
							$products_as_array['photo'] = $photo;
							$reviews = $product->reviews->find()->as_array();
							$specifications = $product->specifications->find()->as_array();
							$products_as_array['specifications'] = $specifications;
							$products_as_array['reviews'] = $reviews;
							$result[] = $products_as_array;	
						}
						$content_view->product = $result;					
						$content = $renderer->render($content_view);												
						$this->template->content = $content;
						Log::instance()->add(Log::NOTICE,Debug::vars('result----',$result));
						
					} else {



						

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
							$products_as_array['photo'] = $photo;
							$reviews = $product->reviews->find()->as_array();
							$specifications = $product->specifications->find()->as_array();
							$products_as_array['specifications'] = $specifications;
							$products_as_array['reviews'] = $reviews;
							$result[] = $products_as_array;	
						}
						
//						Log::instance()->add(Log::NOTICE,Debug::vars('+++++++',$pagination->render()));
						$content_view->product = $result;
						$content_view->pagination = $pagination->render();
						$content = $renderer->render($content_view);		
											
						$this->template->content = $content;
						
					}
					
					
					
//					$content_view->image = '/media/images/shopelement/1.jpg';
					
					/* $products_orm = ORM::factory('Product')
//						->where('id','=',$product->id)
						->find_all(); */
//					if($products){
						/* $model = 'Product';
						if($item_uri){
							$products_orm = ORM::factory($model)
							->where('id','=',$item_uri)
							->find_all();	
							foreach ($products_orm as $product){
								$products_as_array = $product->as_array();				
								$photo = $product->primary_photo()->as_array();
								$products_as_array['photo'] = $photo;
								$result[] = $products_as_array;	
							}
						} else {
							$products_orm = ORM::factory('Product')
			//						->where('id','=',$product->id)
									->find_all();							
							foreach ($products_orm as $product){
								$products_as_array = $product->as_array();				
								$photo = $product->primary_photo()->as_array();
								$products_as_array['photo'] = $photo;
								$result[] = $products_as_array;
							}
							$count = 3;
							$order_by = 'id';
							$pagination = Pagination::factory(array(
								
								'total_items' => $count,
								'current_page'   => array('source' => 'route', 'key' => 'page'), 
								'items_per_page' => 20,
								'view'           => 'pagination/basic',
								'auto_hide'      => TRUE,
							));
							$page_links = $pagination->render();	
							Log::instance()->add(Log::NOTICE,Debug::vars('+++++++',$pagination));
						}*/
							
//						$content_view->product = $result;						
//						$content_view->item = array(array('a'=>array('c'=>'hello c'),'b'=>'hello b'));		 

//						$review = ORM::factory('Product_Review');
//						$review_id = $review->where('product_id','=','1')->find()->as_array();
//						Log::instance()->add(Log::NOTICE,Debug::vars($review_id));						
//						$content = $renderer->render($content_view);						
//						$this->template->content = $content;
						
						
						
//					}
//						Log::instance()->add(Log::NOTICE,Debug::vars());
					
				}
			$this->template->breadcrumbs = 'ok';
		
#		$headermenu = new View_headermenu_index(); 
		
#		$menu = $renderer->render($headermenu);		
//		$menu = View::factory('/personal/menu')
//			->set('lang',$lang);
		
#		$this->template->menu = $menu;		    


		    
    }



    
    public function action_contacts(){

    }
    
    public static function find_view(Request $request)
    {
		// Empty array for view name chunks
		$view_name = array('View');
		
		// If current request's route is set to a directory, prepend to view name
		$request->directory() and array_push($view_name, $request->directory());
		
		// Append controller and action name to the view name array
//		array_push($view_name, $request->controller(), $request->action(), $request->param('pole'));
		array_push($view_name, $request->controller(), $request->action());
		
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);
		
		// Get the path respecting the class naming convention
		$view_path = strtolower(str_replace('_', '/', $view_name));
		
		return array($view_name, $view_path);
    }

} // End 

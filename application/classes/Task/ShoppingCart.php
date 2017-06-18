<?php defined('SYSPATH') OR die('No direct script access.');

class Task_ShoppingCart extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
	private $cart_id;
	private $basket_id;
	private $model;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();	
		// Get the table name from the ORM model			
		
		$cart = Cart::instance();
		$productId = 1;
		$attributes = 'a';
		$this->model = 'Shopping_Cart';		
		$this->delete_item();		
		$this->cart_id = md5(uniqid(rand(), true));
		
		
	/* 	$shopping_cart = ORM::factory($this->model);	
		$shopping_cart->cart_id = $this->cart_id;
		$shopping_cart->product_id = 1; 
		$shopping_cart->quantity = 2;
		$shopping_cart->attributes = 'a'; */
		
		try
		{
			$results = Cart::AddProduct($this->cart_id,$productId, $attributes);//create shopping_cart
			$results = Cart::AddProduct($this->cart_id,$productId, $attributes);	
			$results = Cart::AddProduct($this->cart_id,$productId, $attributes);
			$id;
				
			foreach($results as $result){
				$id = $result['id'];
				Minion_CLI::write('id create - '.$id);				
				Log::instance()->add(Log::NOTICE, Debug::vars($results->as_array()));			
			}	
			$orm = ORM::factory($this->model,$id);
			if($orm->loaded()){
				Minion_CLI::write('shopping_cart quantity of products - '.$orm->quantity);
			}
			Cart::MoveProduct($id);//delete shopping_cart
			Minion_CLI::write('shopping_cart MoveProduct');			
						
			$results = Cart::AddProduct($this->cart_id,$productId, $attributes);
			Minion_CLI::write('shopping_cart AddProduct');
			$orm = ORM::factory($this->model)
				->where('cart_id','=',$this->cart_id)
				->find();

			
			$results = Cart::UpdateProduct($orm->id,5);
			Minion_CLI::write('Create Shopping Cart UpdateProduct to 5 quantity '.$orm->quantity);
			
			$results = Cart::AddProduct($this->cart_id,2, $attributes);
			Minion_CLI::write('add product 2 - ');		
			
			$results = Cart::GetTotalAmount($this->cart_id);
			$total_amount = $results[0]['total_amount'];
//			Log::instance()->add(Log::NOTICE, Debug::vars($total_amount));
			Minion_CLI::write('Create Shopping Cart GetTotalAmount '.$total_amount);
			
			$results = Cart::GetProducts($this->cart_id);
			Minion_CLI::write('GetProducts');
			foreach($results as $result){
				$id = $result['id'];//get cart_id name attributes, subtotal uri
				Minion_CLI::write('id GetProducts - price'.$result['price'].'quantity'.$result['quantity'].'subtotal'.$result['subtotal']);				
//				Log::instance()->add(Log::NOTICE, Debug::vars($result));			
			}	
			
			$results = Cart::SaveProduct($this->cart_id);
			Minion_CLI::write('SaveProduct ');
			$results = Cart::GetTotalAmount($this->cart_id);
			$total_amount = $results[0]['total_amount'];
			Minion_CLI::write('Create Shopping Cart GetTotalAmount after SaveProduct'.$total_amount);
			
//			Log::instance()->add(Log::NOTICE, Debug::vars($orm));
//			
		}
		catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		
		
		
	
		
		
		
//		Minion_CLI::write('Create Shopping Cart instance');
		
		

	}
	
	

	protected function delete_item(){		
		$items = ORM::factory($this->model);		
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	

}


//./minion --task=cart





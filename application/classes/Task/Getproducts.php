<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Getproducts extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
		'id'=>NULL
	);
	
	private $product_id;
	private $photo_id;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();
		// Get the table name from the ORM model	
		$this->product_id = 1;
		$this->photo_id =1;
		$result = array();
		
		if($params['id']){
			$product = ORM::factory('Product',$params['id']);
			$products_as_array = $product->as_array();
			$photo = $product->primary_photo()->as_array();
			$products_as_array['photo'] = $photo;
			$result[] = $products_as_array;
		}else {
			$products = ORM::factory('Product')
//						->where('id','=',$product->id)
						->find_all();
			
			foreach ($products as $product){
				$products_as_array = $product->as_array();				
				$photo = $product->primary_photo()->as_array();
				$products_as_array['photo'] = $photo;
				$result[] = $products_as_array;
//				Log::instance()->add(Log::NOTICE, Debug::vars($product->reviews->find()->as_array()));
//				Log::instance()->add(Log::NOTICE, Debug::vars($product->specifications->find()->as_array()));
				Log::instance()->add(Log::NOTICE, Debug::vars($product->categories->find()->as_array()));
			}
			Minion_CLI::write('Get  products all');
//			Log::instance()->add(Log::NOTICE, Debug::vars($result));
		}
		
//		Log::instance()->add(Log::NOTICE, Debug::vars($products));	
		
		
//		Minion_CLI::write('Get  products instance'.$params['id']);
		

	}
	

}

// ./minion --tasp=getproducts --id=1






<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Basket extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
	private $product_id;
	private $basket_id;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();
		// Get the table name from the ORM model	
		$this->model = 'Basket';
		
		$basket = ORM::factory($this->model);	
		
		$this->delete_item();
		
		
		try{			
			$basket = $basket->save();
			$this->basket_id = $basket->id;
			Minion_CLI::write('id create - '.$this->basket_id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		$this->model_list = 'Catalog_Basket_List';
		$basket_list = new Model_Basket_List();
		$basket_list->basket_id = $this->basket_id;
		$basket_list->product_id = 1;
		$basket_list->quantity = 1;
		
		try{			
			$basket_list = $basket_list->save();
			
			Minion_CLI::write('id basket_list create - '.$basket_list->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		
		
		Minion_CLI::write('Create Basket instance');
		
		

	}
	
	
	
	protected function create_photo($product_id=1,$photo_id=1){


	}
	protected function delete_photo(){

	}
	
	protected function delete_product_review(){

		
	}
	protected function delete_item(){		
		$items = ORM::factory($this->model);		
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	

}








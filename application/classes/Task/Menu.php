<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Menu extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
//	private $product_id;
//	private $basket_id;
	protected $config = 'example';
	protected $menu;
		
	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();
		// Get the table name from the ORM model	
//		$this->model = 'Basket';
		
//		$basket = ORM::factory($this->model);	
		
//		$this->delete_item();
		
		$this->menu = Menu::factory($this->config);
		
		Log::instance()->add(Log::NOTICE, Debug::vars($this->menu->render()));
		
		
		
	
			Minion_CLI::write('Menu create - ');
			
		
		
		
//		Minion_CLI::write('Create Basket instance');
		
		

	}
	
	/* 
	
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
	 */

}








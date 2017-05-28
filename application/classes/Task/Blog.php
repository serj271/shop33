<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Blog extends Minion_Task {
	/* protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	); */
	
	private $cart_id;
	private $basket_id;
	private $model;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
//		Kohana::$config->attach(new comments);		
		$db = Database::instance();	
		// Get the table name from the ORM model			
		
	/* 	$cart = Cart::instance(); */
		$productId = 1;
		$attributes = 'a';
		$this->model = 'Article';
		$group = 'default';
/* 		
		$config = Kohana::$config->load('comments.'.$group);
//		$this->model    = $config['model'];
		$this->per_page = $config['per_page'];
		$this->view     = $config['view'];
		$this->config   = $config; */
		
		
		$date = new Sprig_Field_Timestamp();
//		Minion_CLI::write($date->value('2017-01-01 00:00:00 A'));
		$d = $date->value('2017-01-01 00:00:00 A');
		
		$article = Sprig::factory($this->model, array(
			'id'=>2,
			'parent'=>1,
			'name'=>'test name',
			'email'=>'test@test.li',
			'url'=>'comment1',
			'text'=>'text comment',
			'date'=>$d
	
		));
		$text = new Sprig_Field_Text();		
		$auto = new Sprig_Field_Auto();	
		Minion_CLI::write('article - ');	

		try{			
			$article->save();			
			Minion_CLI::write('id article create - ');			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		} 

		
		 
	/* 	$resent_post = Request::factory(Route::get('comments'))
			->uri(array('id'=>'1','page'=>1))
			->execute()->response; */
	/* 	$url = URL::site('comments');
		$resent_post = Request::factory('/comments/default/create/1/1')->execute();		
		Minion_CLI::write('comment - '.$resent_post); */				
//		
		
		
		
		
	
		
		
		
//		Minion_CLI::write('Create Cart instance');
		
		

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





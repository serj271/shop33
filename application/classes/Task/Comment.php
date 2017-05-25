<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Comment extends Minion_Task {
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
//		Kohana::$config->attach(new comments);		
		$db = Database::instance();	
		// Get the table name from the ORM model			
		
		$cart = Cart::instance();
		$productId = 1;
		$attributes = 'a';
		$this->model = 'Comment';
		$group = 'default';
		
		$config = Kohana::$config->load('comments.'.$group);
//		$this->model    = $config['model'];
		$this->per_page = $config['per_page'];
		$this->view     = $config['view'];
		$this->config   = $config;
		
		
		
		
		$comment = Sprig::factory($this->model)->values(array(
			'parent'=>1,
			'name'=>'test name',
			'email'=>'test@test.li',
			'url'=>'comment1',
			'trxt'=>'text comment'
		
		));
		
		$B8 = B8::factory();
		$probability = $B8->classify($comment->text);
		$state = 'queued';
		if ($probability < $this->config['lower_limit'])
		{
			Kohana::$log->add(Kohana::DEBUG, 'Comment has been classified as ham');
			$state = 'ham';
		}
		else if ($probability > $this->config['upper_limit'])
		{
			Kohana::$log->add(Kohana::DEBUG, 'Comment has been classified as spam');
			$state = 'spam';
		}
		else
		{
			Kohana::$log->add(Kohana::DEBUG, 'Comment has been placed in the moderation queue');
			$state = 'queued';
		}
		$comment->state = $state;

		try
		{
			$comment->create();
			
		}
		catch (Validate_Exception $e)
		{
			// Setup HMVC view with data
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors)); 
			
		}
		
		
		
		
		
		Minion_CLI::write('comment - ');				
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





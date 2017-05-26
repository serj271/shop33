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
		
		$data = Validation::factory(array(
			'id' =>1,
			'parent'=>1,
			'name'=>'test name',
			'email'=>'test@test.li',
			'url'=>'comment1',
			'text'=>'text comment'
		
		))->rule('name','not_empty');
		$data->check();
		$text = new Sprig_Field_Text();
//		Minion_CLI::write($text->input('name','text'));
	/* 	
		$B8 = B8::factory();
		$probability = $B8->classify($comment->text);
		$state = 'queued';
		if ($probability < $this->config['lower_limit'])
		{

			$state = 'ham';
		}
		else if ($probability > $this->config['upper_limit'])
		{

			$state = 'spam';
		}
		else
		{

			$state = 'queued';
		}
		$comment->state = $state;

		try
		{
			$comment->create();
			
		}
		catch (Validate_Exception $e)
		{
//			Setup HMVC view with data
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors)); 
			
		}
		
		 */
		 
	/* 	$resent_post = Request::factory(Route::get('comments'))
			->uri(array('id'=>'1','page'=>1))
			->execute()->response; */
		$url = URL::site('comments');
		$resent_post = Request::factory('/comments/default/create/1/1')->execute();
		
		
		
		
		Minion_CLI::write('comment - '.$resent_post);				
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





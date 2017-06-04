<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Getcomments extends Minion_Task {
	protected $_options = array(
		// param name => default value
//		'foo'   => 'beautiful',
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
		
//		$cart = Cart::instance();
		$productId = 1;
		$attributes = 'a';
		$this->model = 'Comment';
		$group = 'default';
		
		$config = Kohana::$config->load('comments.'.$group);
//		$this->model    = $config['model'];
		$this->per_page = $config['per_page'];
		$this->view     = $config['view'];
		$this->config   = $config;
		
		
//		$date = new Sprig_Field_Timestamp();
//		Minion_CLI::write($date->value('2017-01-01 00:00:00 A'));
//		$d = $date->value('2017-01-01 00:00:00 A');
//		$text = new Sprig_Field_Text();
	/* 	$comment = Sprig::factory($this->model)->values(array(
			'parent'=>2,
			'name'=>'name comment',
			'email'=>'test@test.li',
			'url'=>'',
			'state'=>'queued',
			'text'=>'     text        comment'	
		));		 */
		$offset = 0;
		$query = DB::select()->offset($offset)->order_by('date', $this->config['order']);
		$comments = Sprig::factory($this->model, array(
			))->load(NULL, $this->per_page);
		
//		$comments = $this->load($query, 1);
		Log::instance()->add(Log::NOTICE, Debug::vars($comments[0]->id));
//		$comment = $this->load_by_date('2017/06/02');
//		$date = $comment->date;
		
//		Log::instance()->add(Log::NOTICE, Debug::vars($comment->as_array(),$date));
		
		Minion_CLI::write('Get comments ');
		
		

	}
	

	public function load(Database_Query_Builder_Select $query = NULL, $limit = NULL) {
		if ( ! $query)
		{
			$query = DB::select()->order_by('id', 'DESC')
				->order_by('date', 'DESC');
		}

		return Sprig::factory('Comment')->load($query, $limit);
	}

	/**
	 * Load a specific article by date
	 *
	 * @param   string  published date
	 * @return  Model_Article
	 */
	public function load_by_date($date) {
//		Kohana::$log->add(Kohana::DEBUG,
//			'Executing Model_Blog_Search::load_by_date');

		list($year, $month, $day) = explode('/', $date, 3);
		$begin = strtotime($year.'-'.$month.'-'.$day);
		$end   = strtotime('+1 day', $begin);

		$query = DB::select()
			->where('date', '>=', $begin)
			->where('date', '<', $end);

		return $this->load($query, 1);
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





<?php defined('SYSPATH') or die('No direct script access.');

class View_Basket_Index {
	/**
	 * Alias for the options column (helps separate it from the rest)
	 */
	const OPTIONS_ALIAS = 'options::alias';

	public $model; 

	protected $_includables = array('cart_id','name','quantity','attributes','price','subtotal');//for display columns from table
		
	/**
	 * @var	array	Mustache template
	 */
	protected $_template = 'useradmin/index';

	/**
	 * @var	Database_Result
	 */
	public $items;
	
	/**
	 * @var	Pagination
	 */
	public $pagination;
	
	public $navigator='users ind';
	
    public function message(){
		return 'Hello';	

    }   
	public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function headline()
	{
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->model(),$this->model));
		return ucfirst(Inflector::plural($this->model()));
	} 
	
	public function create_button()
	{
		return array(
			'url' => Route::url('useradmin', array(
				'controller' 	=> $this->controller,
				'action'		=> 'create',
			)),
			'text' => 'Create  new id to '.$this->model(),
		);
	} 
	
	

	public function buttons()
	{
		return array(
			array(
				'class' => 'large',
				'text' => 'Logout',
				'url' => Route::url('user', array(
					'directory' =>'user',
					'controller' => 'auth',
					'action' 		=> 'logout',
				)),
			),
			array(
				'class' => 'large',
				'text' => 'Login',
				'url' => Route::url('user', array(
					'directory' =>'user',
//					'controller' => 'auth',
//					'action' 		=> 'logout',
				)),
			),
			array(
				'class' => 'large',
				'text' => 'Join',
				'url' => Route::url('user', array(
					'directory' =>'user',
					'controller' => 'auth',
					'action' 		=> 'join',
				)),
			),
		);
	}

	protected $_columns;
	
	public function columns()
	{
		if ($this->_columns !== NULL)
			return $this->_columns;
		
		// Create an empty model to get info from
		$model = ORM::factory($this->model);
		
		$columns 	= $model->table_columns();		
		$labels 	= $model->labels();
		
		$result 	= array(
			// Always include the primary key
	/* 		 array(
				'alias' => $model->primary_key(),
				'name' 	=> 'ID',
			), */
		);
		
		// Also include some default columns - if they exist
		foreach ($this->_includables as $includable)
		{
//			if (isset($columns[$includable]))
//			{
				$label = Arr::get($labels, $includable, $includable);
				
				$result[] = array(
					'alias' => $includable,
					'name' 	=> ucfirst($label),
				);
//			}
		}
		/* 
		$result[] = array(
					'alias' => 'options',
					'name' 	=> 'options',
				);
		$result[] = array(
			'alias' => 'options',
			'name' 	=> 'options',
		); */
		
		// Include the created column - if it exists
		/* if ($created = $model->created_column())
		{
			$result[] = array(
				'type'	=> 'created_column',
				'alias' => $created['column'],
				'name' 	=> 'Created',
			);
		}
		
		// Include the updated column - if it exists
		if ($updated = $model->updated_column())
		{
			$result[] = array(
				'type'	=> 'updated_column',
				'alias' => $updated['column'],
				'name' 	=> 'Last update',
			);
		}
		
		// Append the options array the last
		$result[] = array(
			'alias' => static::OPTIONS_ALIAS,
			'name'	=> 'Options',
		); */
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->_includables));		
		return $this->_columns = $result;
	}

	/**
	 * List of available actions to display for each individual row
	 *
	 * @return	array
	 */
	public function options()
	{
		return array(
			'read' => array(
				'class' 	=> 'btn primary',
				'text' 		=> 'View',
			),
			'update' => array(
				'class' 	=> 'btn success',
				'text' 		=> 'Edit',
			),
			'delete' => array(
				'class' 	=> 'btn danger',
				'text' 		=> 'Delete',
			),
		);
	}
	
	/**
	 * @var	mixed	local cache for self::results()
	 */
	protected $_result;
	
	public function result_count(){
		return count($this->items);
	}
	
	/**
	 * Resultset (table body rows)
	 * 
	 * @return	array	(empty if no results)
	 */
	public function result()
	{
		if ($this->_result !== NULL)
			return $this->_result;
		
		$result = array();
		
		if (count($this->items) > 0)
		{
			$result['rows'] = array();
			
			
			foreach ($this->items as $item)
			{
				// Extract aliased values from self::columns()
				$aliases 	= Arr::pluck($this->columns(), 'alias');
				$extracted 	= Arr::extract($item, $aliases);
//				Log::instance()->add(Log::NOTICE, Debug::vars('iteeee',$item));
				// Remove the options aliased column
//				unset($extracted[static::OPTIONS_ALIAS]);
				
				$values = array_values($extracted);
				
				// Map all values to array('value' => $value)
				$values = array_map(function($val) { 
					
					return array('value' => $val);
				
				}, $values);
//				
				
				// Map options
				$options = array();
				
				foreach ($this->options() as $action => $details)
				{
					$options[] = array(
						'class' => $details['class'],
						'text' 	=> $details['text'],
						'url'	=> Route::url('product', array(
							'controller' 	=> 'product',
//							'action'		=> $action,
							'item_uri'			=> $item['uri'],//$item->id
						)),
					);
				}
//				$options = array();
				
				// Push data to the rows array
				$result['rows'][] = array(
//					'item'		=> $item,
					'options' 	=> $options,
					'values' 	=> $values,
				);
			}
		}
		
		return $this->_result = $result;
	}



	public function repo(){
		return array('name'=>'repo');
		
	}

	public function norepo(){
		return array();		
	}
	




	
}

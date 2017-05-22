<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Generic (R)EAD view model - for single record
 */
class View_Product_Main_Read {
	public $model;

	public function model()
	{
//		return Inflector::humanize($this->model);
	}	
//	protected $_template = 'admin/read';
//	protected $_includables = array('logins','password');//for not sho columns from table
	/**
	 * @var	Model
	 */
	public $item;

	
	
	/**
	 * @return	array	Available buttons
	 */
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Update',
				'url' => Route::url('useradmin', array(
					'controller' 	=> $this->controller,
					'action' 		=> 'update',
//					'id' 			=> $this->item->id,
				)),
			),
			array(
				'class' => 'large error',
				'text' => 'Delete',
				'url' => Route::url('useradmin', array(
					'controller' 	=> $this->controller,
					'action' 		=> 'delete',
//					'id' 			=> $this->item->id,
				)),
			),
		);
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
//		return ucfirst($this->model()).' #'.$this->item->id;
	}
	
	/**
	 * @return	array	field => value
	 */
	public function values()
	{
		$array 	= $this->item->object();
		$labels = $this->item->labels();
		Log::instance()->add(log::NOTICE, Debug::vars( $labels, $array['uri']));
		
		$result = array();
		$photo = $this->item->primary_photo()->as_array();			
		$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
		
		foreach ($array as $field => $value)
		{				
			/* if(in_array($field, $this->_includables)){
			    continue;
			}
			$push = array(
				'label' => Arr::get($labels, $field),
				'value' => $value,
			);
			
			if ($push['label'] === NULL)
			{				
				$push['label'] = ucfirst(Inflector::humanize($field));
			}			
						
			$result[] = $push; */				
		}
		
		
		$result[] = array(
				'name' => $labels['name'],
				'photo' =>$photo,
				'id'	=>$this->item->id,
		);
		return $result;
	} 
	
	
	public static function addBase($url){
			return URL::base().$url;			
	} 
	
}

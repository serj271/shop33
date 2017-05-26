<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Generic (D)ELETE view model - for single records
 */
class View_Basket_Delete{
	
	protected $_template = 'admin/delete';

	/**
	 * @var	ORM		model
	 */
	public $item;
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}

	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Confirm '.$this->model().' deletion';
	}
	
}
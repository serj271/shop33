<?php

class View_Useradmin_News_Navigator extends View_Bootstrap_Navigator_Useradminform
{
	public $message;	
	/**
	 * @var	mixed	[Kostache|Formo] form
	 */
	public $form;
	/**
	 * @var	ORM		model
	 */
	public $item;	
	/**
	 * @var	array	validation errors
	 */
	public $errors;	
	/*
	* 
	*/
	public $id;
//	protected $_template = 'admin/create';

	public $model='useradmin';
	
	public $checked_show_all;
	public $checked_show_select;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
	/*
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Create a new '.$this->model().' '.$this->id_listing;
	}
	
	public function message(){
		return Message::display('message/basic');
	}
	
	



//    public $results;
   
}
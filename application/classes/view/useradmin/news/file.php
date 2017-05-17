<?php

class View_Useradmin_News_File
{
//    public $labelUsername;
//    public $labelId;
//    public $results;
   
//    public  $formatPassword =  false;
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
	
	public function model()
	{
		return Inflector::humanize($this->model);
	}	
	/**
	 * Returns the form for current view
	 */

	public function title()
	{
	    return 'title';
	}

	public function button()
	{
	    return 'upload';
	}

	public $toForm;	
 
   
}
<?php defined('SYSPATH') or die('No direct script access.');

class View_Basket_Index {

	public $model; 

    public function message(){
	return 'Hello! basket';	

    }   
	public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function headline()
	{
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
		);
	}













	
}

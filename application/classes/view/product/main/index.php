<?php defined('SYSPATH') or die('No direct script access.');

class View_Product_Main_Index {


//	public function model()
//	{
//		return Inflector::humanize($this->model);
//	}	
	public $items;
   
	public $pagination;
    
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Product',
				'url' => Route::url('product', array(
					'directory' =>'product',
					'controller' => 'main',
					'action'     => 'index',
				)),
			),			
		);
	} 
	
	
	
	
    public function message(){
	return 'Hello pro';	

    }   

	
}

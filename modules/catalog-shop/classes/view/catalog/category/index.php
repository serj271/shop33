<?php defined('SYSPATH') or die('No direct script access.');

class View_Catalog_Category_Index {

    public function __construct(){	
		
		$this->value=6;
    }
    public $value=9;
    public $results = array();
    public $title;

    public function message(){
	

    }   

    public $products = array();


    public function count_products(){
	return count($this->products);
    }
    
    














	
}

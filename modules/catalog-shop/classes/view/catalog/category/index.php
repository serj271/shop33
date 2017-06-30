<?php defined('SYSPATH') or die('No direct script access.');

class View_Catalog_Category_Index {

    public function __construct(){	
		
		$this->value=6;
    }
    public $value=9;
    public $results = array();
    public $title;

    public $breadcrumbs = array();
     
  

    public $name='name';
	public function bold()
	{	    
		return function($text) {
//		    return ucfirst((string) $text);
			return '<b>'.$text.'</b>';
		};
	}

    public function linkUser()
		{
		return function($text)
		{
	//	    return "<a href='#'>".$text."</a>";
			return HTML::anchor('personalviewerproperty/id/'.$text, $text);
		};
    
    }


    public $products = array();


    public function count_products(){
	return count($this->products);
    }
    
    














	
}

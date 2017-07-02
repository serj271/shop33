<?php defined('SYSPATH') or die('No direct script access.');

class View_Catalog_Category_Index {

    public function __construct(){	
		
		$this->value=6;
    }
    public $value=9;
    public $results = array();
    public $title;

    public $breadcrumbs = array();
     
    public $categories = array();  

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

/* 
    public function listCategories(){
		result = array();
		foreach ($this->categories as $category){
			$uri = $category->uri;
			$uri = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('uri'));//
			
		}
		
		
    
    }
 */
/* 
	public static function addBase($url){		
		return URL::base().$url;			
	} 	 */
	
    public $products = array();

    public function count_products(){
	return count($this->products);
    }
    
    














	
}

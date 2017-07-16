<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_Catalog_Getcatalog extends Controller {

    public function action_index() {
//		$json_data=array('d'=>6);

		$categories = ORM::factory('Catalog_Category')
			->where('level','=',0)
			->find_all();	
		
		$result = array();
		foreach($categories as $categorie){			
			$result[] = $categorie->as_array();
		}
	
		$this->response->headers('Content-type','application/json;charset=UTF-8');
		$this->response->body(json_encode($result));

    }










} // End 

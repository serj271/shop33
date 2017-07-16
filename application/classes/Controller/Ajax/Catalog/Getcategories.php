<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_Catalog_Getcategories extends Controller {

    public function action_index() {
//		$json_data=array('d'=>6);

		$request = $this->request->current();
		$query_controller = $request->query('controller');		
		$uri = $this->request->param('category_uri');
		$uri = rtrim($uri, '/');
	/* 	if($uri == 'catalog'){					
//			return TRUE;
		} */
		$asParts = @ explode('/',$uri);
		/* $prefix = @ $asParts[0];
//		$action = @ $asParts[1];
		if($prefix !== 'catalog'){
//			return FALSE;
		}		 */
		
		$uri = str_replace('catalog/','', $uri);	

		$category_uri = $asParts[count($asParts)-1];//current categorie uri	
		$category_id = ORM::factory('Catalog_Category')
			->where('uri','=',$category_uri)
			->find()
			->id;
				
		$categories = ORM::factory('Catalog_Category',$category_id) //as catalog_category_id
			->categories
			->find_all();//category_uri unique must be
			
//		$cat = $this->_get_categories_list();			
			Log::instance()->add(Log::NOTICE, Debug::vars('categorie',$categories,$category_uri));
		
		$result = array();
		foreach($categories as $categorie){			
			$result[] = $categorie->as_array();
//			Log::instance()->add(Log::NOTICE, Debug::vars($categorie->as_array()));
		}
	
		$this->response->headers('Content-type','application/json;charset=UTF-8');
		$this->response->body(json_encode($result));

    }




	protected function _get_categories_list()
	{
		$categories_db = ORM::factory('Catalog_Category')
			->order_by('catalog_category_id', 'asc')
			->order_by('position', 'asc')
			->find_all();
		
		$categories = array();
		foreach ($categories_db as $_item) {
			$_key = $_item->id;
			if ($_item->catalog_category_id == 0) {
				$categories[$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => 0,
					'children' => array(),
				);
			} elseif (array_key_exists($_item->catalog_category_id, $categories)) {
				$_parent = & $categories[$_item->catalog_category_id];
				
				$_parent['children'][$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => $_parent['level'] + 1,
					'children' => array(),
				);
				unset($_parent);
			}
		}
			
		return $categories;
	}







} // End 

<?php defined('SYSPATH') or die('No direct script access.');
/*
 * TODO: добавить кеширование
 */
function category_uri_list() {
	$list = ORM::factory('Catalog_Category')
		->order_by('level', 'asc')
		->find_all();
	$result = array();
	foreach ($list as $_orm) {
		if ($_orm->level > 0 AND array_key_exists($_orm->category_id, $result)) {
			$result[$_orm->id] = $result[$_orm->category_id].'/'.$_orm->uri;
		} elseif ($_orm->level == 0) {
			$result[$_orm->id] = $_orm->uri;
		}
	}
	return $result;
}
$module_type = Kohana::$config->load('catalog.mode');
//Log::instance()->add(Log::NOTICE, 'type__'.$module_type);
if ($module_type === 'root') {
	
	$routes = Kohana::$config->load('routes/catalog')
		->as_array();
	
	foreach ($routes as $_name => $_config) {
/* 		Route::set($_name, Arr::get($_config, 'uri_callback', Arr::get($_config, 'regex')))
			->defaults(Arr::get($_config, 'defaults'));	 */
	}

	/* 
	Route::set('testing', function($uri)
	{
		if($uri == 'foo/bar')
		return array(
			'controller'=>'welcome1',
			'action'=>'index'
		);
	}); */
	
	
	Route::set('testing', 'testing')
		->defaults(
			array(
//				'directory'=>'catalog',
				'controller' => 'welcome',
				'action' => 'index'
			)	
		)
		->filter(
			function($route, $params, $request) 
			{
			/*   $result = DB::select(
				'id', 
				'uri', 
				'route_directory', 
				'route_controller', 
				'route_action', 
				'route_id'
			  )->from('router')
			  ->where('uri', '=', $request->uri())
			  ->execute();
			  if ($result->count() > 0)
			  {   
				$params['directory'] = $result->get('route_directory', '');
				$params['controller'] = $result->get('route_controller', 0);
				$params['action'] = $result->get('route_action', 0);
				$params['id'] = $result->get('route_id', 0);
			  }
			  else 
			  {
				$params['controller'] = 'Website';
				$params['action'] = 'index';
			  } */
				$params['controller'] = 'Welcome';
				$params['action'] = 'index';
			return true;
			}
		);
		
/*	
	Route::set('catalog',  function($uri)
	{
		$categories = category_uri_list();
		Log::instance()->add(Log::NOTICE, Debug::vars('cat',$categories));	
		Log::instance()->add(Log::NOTICE, Debug::vars('regex',$uri));
		$uri = rtrim($uri, '/');
		$asParts = @ explode('/',$uri);
		$prefix = @ $asParts[0];
//		$action = @ $asParts[1];
		if($prefix !== 'catalog'){
			return FALSE;
		}		
		$uri = str_replace('catalog/','', $uri);
			
		if (!in_array($uri, $categories)) {
			return FALSE;
		}
		$params = array(
			'directory'=>'catalog',
			'controller' => 'category',
			'action' => 'index'
		);
		$params['category_uri'] = array();
		$sergments = explode('/', $uri);
		foreach ($sergments as $_seg) {
			$params['category_uri'][] = $_seg;
		}
		
		return $params;			
	});
	
*/
/*
	Route::set('catalog/element','catalog/element(/<element_uri>)',array(
		'element_uri'=>'.*'
	))->defaults(
		array(
			'directory'=>'catalog',
			'controller' => 'element',
			'action' => 'index'
		)	
	);
*/
	/*  Route::set('catalog/item','catalog/item(/<item_uri>)',array(
		'item_uri'=>'.*'
	))->defaults(
		array(
			'directory'=>'catalog',
			'controller' => 'item',
			'action' => 'index'
		)	
	); */

	Route::set('catalog/main', 'catalog(/<category_uri>)')->defaults(
		array(
			'directory'=>'catalog',
			'controller' => 'category',
			'action' => 'index'
		)
	)
	->filter(
			function(Route $route, $params, Request $request) 			
			{
				$uri = $request::detect_uri();

//				Log::instance()->add(Log::NOTICE, Debug::vars($route, $params, $request));
			/*   $result = DB::select(
				'id', 
				'uri', 
				'route_directory', 
				'route_controller', 
				'route_action', 
				'route_id'
			  )->from('router')
			  ->where('uri', '=', $request->uri())
			  ->execute();
			  if ($result->count() > 0)
			  {   
				$params['directory'] = $result->get('route_directory', '');
				$params['controller'] = $result->get('route_controller', 0);
				$params['action'] = $result->get('route_action', 0);
				$params['id'] = $result->get('route_id', 0);
			  }
			  else 
			  {
				$params['controller'] = 'Website';
				$params['action'] = 'index';
			  } */
				/* $params['controller'] = 'Welcome';
				$params['action'] = 'index'; */
//				$params['category_uri'] = array();
//				$params['category_uri'][] = 'category0';
			/* 	if($params['category_uri'] == 'category0'){
					return true;
				} */
				
				$categories = category_uri_list();		
				$uri = rtrim($uri, '/');
				if($uri == 'catalog'){					
					return true;
				}
				$asParts = @ explode('/',$uri);
				$prefix = @ $asParts[0];
		//		$action = @ $asParts[1];
				if($prefix !== 'catalog'){
					return FALSE;
				}		
				
				$uri = str_replace('catalog/','', $uri);	
				if (!in_array($uri, $categories)) {
					return FALSE;
				}		
			}
	);
	
	
	
	
	/* 
	Route::set('ajax', function($uri)
    {
        if (Request::$current->is_ajax() AND $params = Route::get('default')->matches($uri))
        {
            $params['directory'] = 'ajax';
            return $params;
        }
    },
    '(<controller>(/<action>(/<id>)))'
	);
	 */
	
	
	
	
	
	
}


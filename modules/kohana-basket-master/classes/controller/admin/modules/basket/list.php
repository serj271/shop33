<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Basket_List extends Controller_Admin_Modules_Basket {

	private $basket_id;
	
	public function before()
	{
		parent::before();
		
		$this->basket_id = (int) $this->request
			->query('basket');
		
		$this->template
			->bind_global('BASKET_ID', $this->basket_id);
			
	}
	
	public function action_index()
	{
		if (empty($this->basket_id)) {
			throw new HTTP_Exception_404();
		}
		
		$orm = ORM::factory('basket_List')
			->where('basket_id', '=', $this->basket_id);
		
		$list_db = $orm
			->order_by('id')
			->find_all();
		
		$list = array();
		foreach ($list_db as $_orm) {
			$list[] = array(
				'id' => $_orm->id,
				'name' => $_orm->name,
				'count' => $_orm->count,
				'price' => $_orm->price,
			);
		}	
			
		$this->template
			->set_filename('modules/basket/list/list')
			->set('list', $list);
			
		$this->left_menu_element_list();
		$this->left_menu_element_add();
		$this->sub_title = __('List');;
	}

	public function action_edit()
	{
		if (empty($this->basket_id)) {
			throw new HTTP_Exception_404();
		}
		
		$request = $this->request->current();
		$id = (int) $request->param('id');
		$helper_orm = ORM_Helper::factory('basket_List');
		$orm = $helper_orm->orm();
		if ( (bool) $id) {
			$orm
				->where('id', '=', $id)
				->find();
		
			if ( ! $orm->loaded()) {
				throw new HTTP_Exception_404();
			}
			$this->title = __('Edit item');
		} else {
			$this->title = __('Add item');
		}
		
		if (empty($this->back_url)) {
			$query_array = array(
				'basket' => $this->basket_id
			);
			$query_array = Paginator::query($request, $query_array);
			$this->back_url = Route::url('modules', array(
				'controller' => $this->controller_name['basket'],
				'query' => Helper_Page::make_query_string($query_array),
			));
		}
		
		if ($this->is_cancel) {
			$request
				->redirect($this->back_url);
		}
		
		$errors = array();
		$submit = $request->post('submit');
		if ($submit) {
			try {
				if ( (bool) $id) {
					$orm->updater_id = $this->user->id;
					$orm->updated = date('Y-m-d H:i:s');
					$reload = FALSE;
				} else {
					$orm->creator_id = $this->user->id;
					$orm->basket_id = $this->basket_id;
					$reload = TRUE;
				}
				
				$values = $request->post();
				$helper_orm->save($values + $_FILES);
				
				if ($reload) {
					if ($submit != 'save_and_exit') {
						$this->back_url = Route::url('modules', array(
							'controller' => $request->controller(),
							'action' => $request->action(),
							'id' => $orm->id,
							'query' => Helper_Page::make_query_string($request->query()),
						));
					}
						
					$request
						->redirect($this->back_url);
				}
			} catch (ORM_Validation_Exception $e) {
				$errors = $this->errors_extract($e);
			}
		}

		// If add action then $submit = NULL
		if ( ! empty($errors) OR $submit != 'save_and_exit') {
			
			$this->template
				->set_filename('modules/basket/list/edit')
				->set('errors', $errors)
				->set('helper_orm', $helper_orm)
				;
			
			$this->left_menu_element_list();
			$this->left_menu_element_add();
		} else {
			$request
				->redirect($this->back_url);
		}
	}
	
	public function action_delete()
	{
		if (empty($this->basket_id)) {
			throw new HTTP_Exception_404();
		}
		
		$request = $this->request->current();
		$id = (int) $request->param('id');
		
		$helper_orm = ORM_Helper::factory('basket_List');
		$orm = $helper_orm->orm();
		$orm
			->and_where('id', '=', $id)
			->find();
		
		if ( ! $orm->loaded()) {
			throw new HTTP_Exception_404();
		}
		
		if ($this->element_delete($helper_orm)) {
			if (empty($this->back_url)) {
				$query_array = array(
					'basket' => $this->basket_id
				);
				$query_array = Paginator::query($request, $query_array);
				$this->back_url = Route::url('modules', array(
					'controller' => $this->controller_name['basket'],
					'query' => Helper_Page::make_query_string($query_array),
				));
			}
		
			$request
				->redirect($this->back_url);
		}
	}
	
	public function action_products()
	{
		$this->auto_render = FALSE;
		$this->auto_send_cache_headers = FALSE;
	
		$list = ORM::factory('catalog_Element')
			->order_by('title', 'asc')
			->find_all();
		
		$data = array();
		foreach ($list as $_orm) {
			$_title = '<b>'.$_orm->title.'</b>';
			if ( ! empty($_orm->code)) {
				$_title .= ' ['.$_orm->code.']';
			}
			$data[] = array(
				'id' => $_orm->id,
				'name' => $_title,
				'source' => Route::url('modules', array(
					'controller' => $this->controller_name['basket'],
					'action' => 'nomenclatures',
					'id' => $_orm->id
				))
			);
		}
		
		$this->json_send($data, Date::MINUTE);
	}
	
	public function action_nomenclatures()
	{
		$this->auto_render = FALSE;
		$this->auto_send_cache_headers = FALSE;
	
		$id = (int) $this->request
			->param('id');
		
		$product_orm = ORM::factory('catalog_Element', $id);
			
		if (empty($id) OR ! $product_orm->loaded()) {
			throw new HTTP_Exception_404();
		}
	
		$list = ORM::factory('nomenclature')
			->where('product_id', '=', $id)
			->order_by('title', 'asc')
			->find_all();
		
		$data = array();
		foreach ($list as $_orm) {
			$_title = $_orm->title;
			if ( ! empty($_orm->code)) {
				$_title .= ' ['.$_orm->code.']';
			}
			$data[] = array(
				'id' => $_orm->id,
				'name' => $_title,
				'title' => make_nomenclature_name($product_orm, $_orm),
			);
		}
		
		$this->json_send($data, Date::MINUTE);
	}
	
	protected function _get_breadcrumbs()
	{
		$breadcrumbs = parent::_get_breadcrumbs();
		
		$basket_orm = ORM::factory('basket', $this->basket_id);
		if ($basket_orm->loaded()) {
			
			if (empty($this->back_url)) {
				$query_array = array(
					'basket' => $this->basket_id
				);
				$link = Route::url('modules', array(
					'controller' => $this->controller_name['basket'],
					'query' => Helper_Page::make_query_string($query_array),
				));
			} else {
				$link = $this->back_url;
			}
			
			$breadcrumbs[] = array(
				'title' => __('Order №').$basket_orm->id,
				'link' => $link,
			);
		}
		
		$request = $this->request->current();
		$action = $request
			->action();
		if (in_array($action, array('edit'))) {
			$id = (int) $request->param('id');
			$element_orm = ORM::factory('basket_List')
				->where('id', '=', $id)
				->find();
			if ($element_orm->loaded()) {
				$breadcrumbs[] = array(
					'title' => ' ['.__('edit item').']',
				);
			} else {
				$breadcrumbs[] = array(
					'title' => ' ['.__('new item').']',
				);
			}
		}
		
		return $breadcrumbs;
	}
} 

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Basket_Element extends Controller_Admin_Modules_Basket {

	public function action_index()
	{
		$orm = ORM::factory('basket');
		
		$paginator_orm = clone $orm;
		$paginator = new Paginator('admin/layout/paginator');
		$paginator
			->per_page(20)
			->count($paginator_orm->count_all());
		unset($paginator_orm);
		
		$list = $orm
			->paginator($paginator)
			->find_all();
		
		$status_list = Kohana::$config->load('_basket.status');
			
		$this->template
			->set_filename('modules/basket/element/list')
			->set('list', $list)
			->set('paginator', $paginator)
			->set('status_list', $status_list);
			
		$this->left_menu_element_list();
		$this->left_menu_element_add();
		$this->sub_title = __('Orders list');;
	}

	public function action_edit()
	{
		$request = $this->request->current();
		$id = (int) $request->param('id');
		$helper_orm = ORM_Helper::factory('basket');
		$orm = $helper_orm->orm();
		if ( (bool) $id) {
			$orm
				->where('id', '=', $id)
				->find();
		
			if ( ! $orm->loaded() OR ! $this->acl->is_allowed($this->user, $orm, 'edit')) {
				throw new HTTP_Exception_404();
			}
			$this->title = __('Edit order');
		} else {
			$this->title = __('Add order');
		}
		
		if (empty($this->back_url)) {
			$query_array = array(
			);
			$query_array = Paginator::query($request, $query_array);
			$this->back_url = Route::url('modules', array(
				'controller' => $this->controller_name['element'],
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
			
			$status_list = Kohana::$config->load('_basket.status');
			$user = $this->_get_user($orm->user_id);
			
			$this->template
				->set_filename('modules/basket/element/edit')
				->set('helper_orm', $helper_orm)
				->set('status_list', $status_list)
				->set('user', $user);
			
			$injector = $this->injectors['list'];
			if ($orm->loaded()) {
				try {
					$this->hook_list_content[] = $injector->get_hook($orm);
			
					$this->menu_left_add( $injector->menu_list() );
					$this->menu_left_add( $injector->menu_add($orm) );
			
				} catch (ORM_Validation_Exception $e) {
					$errors = array_merge($errors, $this->errors_extract($e));
				}
			}
				
			$this->template
				->set('errors', $errors);
				
			$this->left_menu_element_list();
			$this->left_menu_element_add();
		} else {
			$request
				->redirect($this->back_url);
		}
	}
	
	public function action_delete()
	{
		$request = $this->request->current();
		$id = (int) $request->param('id');
		
		$helper_orm = ORM_Helper::factory('basket');
		$orm = $helper_orm->orm();
		$orm
			->and_where('id', '=', $id)
			->find();
		
		if ( ! $orm->loaded() OR ! $this->acl->is_allowed($this->user, $orm, 'edit')) {
			throw new HTTP_Exception_404();
		}
		
		if ($this->element_delete($helper_orm)) {
			if (empty($this->back_url)) {
				$query_array = array(
				);
				$query_array = Paginator::query($request, $query_array);
				$this->back_url = Route::url('modules', array(
					'controller' => $this->controller_name['element'],
					'query' => Helper_Page::make_query_string($query_array),
				));
			}
		
			$request
				->redirect($this->back_url);
		}
	}
	
	private function _get_user($user_id)
	{
		$result = array(
			'id' => $user_id,
			'name' => __('unregistered'),
			'link' => NULL,
		);
		
		return $result;
	}
	
	protected function _get_breadcrumbs()
	{
		$breadcrumbs = parent::_get_breadcrumbs();
		
		$request = $this->request->current();
		$action = $request
			->action();
		if (in_array($action, array('edit'))) {
			$id = (int) $request->param('id');
			$element_orm = ORM::factory('basket')
				->where('id', '=', $id)
				->find();
			if ($element_orm->loaded()) {
				switch ($action) {
					case 'edit':
						$_str = ' ['.__('edition').']';
						break;
					default:
						$_str = '';
				}
				
				$breadcrumbs[] = array(
					'title' => __('Order №').$element_orm->id.$_str,
				);
			} else {
				$breadcrumbs[] = array(
					'title' => ' ['.__('new order').']',
				);
			}
		}
		
		return $breadcrumbs;
	}
} 

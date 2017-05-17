<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Basket extends Controller_Admin_Front {

	protected $module_config = 'basket';
	protected $menu_active_item = 'modules';
	protected $title = 'Basket';
	protected $sub_title = 'Basket';
	
	protected $controller_name = array(
		'element' => 'basket_element',
		'basket' => 'basket_list',
	);
	
	protected $injectors = array(
		'list' => array('Injector_Basket_List'),
	);
	
	public function before()
	{
		parent::before();
	
		$request = $this->request;
		$query_controller = $request->query('controller');
		if ( ! empty($query_controller) AND is_array($query_controller)) {
			$this->controller_name = $request->query('controller');
		}
		$this->template
			->bind_global('CONTROLLER_NAME', $this->controller_name);
		
		$this->title = __($this->title);
		$this->sub_title = __($this->sub_title);
	}
	
	protected function layout_aside()
	{
		$menu_items = array_merge_recursive(
			Kohana::$config->load('admin/aside/basket')->as_array(),
			$this->menu_left_ext
		);
		
		return parent::layout_aside()
			->set('menu_items', $menu_items);
	}

	protected function left_menu_element_list()
	{
		if (empty($this->back_url)) {
			$query_array = array(
			);
			$link = Route::url('modules', array(
				'controller' => $this->controller_name['element'],
				'query' => Helper_Page::make_query_string($query_array),
			));
		} else {
			$link = $this->back_url;
		}
		
		$this->menu_left_add(array(
			'basket' => array(
				'title' => __('Orders list'),
				'link' => $link,
				'sub' => array(),
			),
		));
	}
	
	protected function left_menu_element_add()
	{
		$query_array = array(
		);
		$this->menu_left_add(array(
			'basket' => array(
				'sub' => array(
					'add' => array(
						'title' => __('Add order'),
						'link' => Route::url('modules', array(
							'controller' => $this->controller_name['element'],
							'action' => 'edit',
							'query' => Helper_Page::make_query_string($query_array),
						)),
					),
				),
			),
		));
	}
	
	protected function _get_breadcrumbs()
	{
		if (empty($this->back_url)) {
			$query_array = array(
			);
			$link = Route::url('modules', array(
				'controller' => $this->controller_name['element'],
				'query' => Helper_Page::make_query_string($query_array),
			));
		} else {
			$link = $this->back_url;
		}
		
		return array(
			array(
				'title' => __('Basket'),
				'link' => $link,
			)
		);
	}
}


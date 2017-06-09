<?php defined('SYSPATH') or die('No direct script access.');

class Injector_Basket_List extends Injector_Base {
	
	private $controller_name = 'basket_list';
	private $tab_code = 'list';
	
	public function get_hook($orm)
	{
		return array(
			array($this, 'hook_callback'),
			array($orm)
		);
	}
	
	public function hook_callback($content, $orm)
	{
		$request = $this->request;
		$back_url = $request->url();
		$query_array = $request->query();
		if ( ! empty($query_array)) {
			$back_url .= '?'.http_build_query($query_array);
		}
		$back_url .= '#tab-'.$this->tab_code;
		unset($query_array);
	
		$query_array = array(
			'basket' => $orm->id,
			'back_url' => $back_url,
			'content_only' => TRUE
		);
		$query_array = Paginator::query($request, $query_array);
		$link = Route::url('modules', array(
			'controller' => $this->controller_name,
			'query' => Helper_Page::make_query_string($query_array),
		));
	
		$html_blog = Request::factory($link)
			->execute()
			->body();
	
		$tab_nav_html = View_Admin::factory('layout/tab/nav', array(
			'code' => $this->tab_code,
			'title' => '<b>'.__('Products list').'</b>',
		));
		$tab_pane_html = View_Admin::factory('layout/tab/pane', array(
			'code' => $this->tab_code,
			'content' => $html_blog
		));
	
		return str_replace(array(
			'<!-- #tab-nav-insert# -->', '<!-- #tab-pane-insert# -->'
		), array(
			$tab_nav_html.'<!-- #tab-nav-insert# -->', $tab_pane_html.'<!-- #tab-pane-insert# -->'
		), $content);
	}
	
	public function menu_list()
	{
		return array(
			'basket_list' => array(
				'title' => __('Products list'),
				'link' => '#tab-'.$this->tab_code,
				'class' => 'tab-control',
				'sub' => array(),
			),
		);
	}
	
	public function menu_add($orm)
	{
		$back_url = $_SERVER['REQUEST_URI'].urlencode('#tab-').$this->tab_code;

		return array(
			'basket_list' => array(
				'sub' => array(
					'add' => array(
						'title' => __('Add item'),
						'link' => Route::url('modules', array(
							'controller' => $this->controller_name,
							'action' => 'edit',
							'query' => 'basket='.$orm->id.'&back_url='.$back_url
						)),
					),
				),
			),
		);
	}
	
}
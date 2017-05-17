<?php defined('SYSPATH') or die('No direct access allowed.');

	echo View_Admin::factory('layout/breadcrumbs', array(
		'breadcrumbs' => $breadcrumbs
	));

	$orm = $helper_orm->orm();
	$labels = $orm->labels();
	$required = $orm->required_fields();

	$query_array = array(
		'basket' => $BASKET_ID,
	);
	if ( ! empty($BACK_URL)) {
		$query_array['back_url'] = $BACK_URL;
	}

	if ($orm->loaded()) {
		$query_array = Paginator::query(Request::current(), $query_array);
		$action = Route::url('modules', array(
			'controller' => $CONTROLLER_NAME['basket'],
			'action' => 'edit',
			'id' => $orm->id,
			'query' => Helper_Page::make_query_string($query_array),
		));
	} else {
		$action = Route::url('modules', array(
			'controller' => $CONTROLLER_NAME['basket'],
			'action' => 'edit',
			'query' => Helper_Page::make_query_string($query_array),
		));
	}
	
	echo View_Admin::factory('layout/error')
		->bind('errors', $errors);
?>

	<form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" >
		<div class="tabbable">
			<ul class="nav nav-tabs kr-nav-tsbs">
<?php
				echo '<li class="active">', HTML::anchor('#tab-main', __('Main'), array(
					'data-toggle' => 'tab'
				)), '</li>'; 
?>
				<!-- #tab-nav-insert# -->
			</ul>
			<div class="tab-content kr-tab-content">
				<div class="tab-pane kr-tab-pane active" id="tab-main">
<?php
					echo View_Admin::factory('modules/basket/list/tab/main', array(
						'helper_orm' => $helper_orm,
						'errors' => $errors,
						'source' => Route::url('modules', array(
							'controller' => $CONTROLLER_NAME['basket'],
							'action' => 'products',
						)),
					)); 
?>
				</div>
				<!-- #tab-pane-insert# -->
			</div>
		</div>
<?php
		echo View_Admin::factory('form/submit_buttons');
?>	
	</form>

<?php defined('SYSPATH') or die('No direct access allowed.'); 

	if (Request::current()->is_initial()) {
		echo View_Admin::factory('layout/breadcrumbs', array(
			'breadcrumbs' => $breadcrumbs
		));
	}

	if ($list->count() <= 0) {
		return;
	}

	$query_array = array(
	);
	if ( ! empty($BACK_URL)) {
		$query_array['back_url'] = $BACK_URL;
	}

	$query_array = Paginator::query(Request::current(), $query_array);
	$edit_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['element'],
		'action' => 'edit',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$delete_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['element'],
		'action' => 'delete',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
?>

	<table class="table table-bordered table-striped">
		<colgroup>
			<col class="span1">
			<col class="span2">
			<col class="span2">
			<col class="span2">
			<col class="span2">
		</colgroup>
		<thead>
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('Email'); ?></th>
				<th><?php echo __('Phone'); ?></th>
				<th><?php echo __('Status'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php 			
		$orm_helper = ORM_Helper::factory('nomenclature');
		foreach ($list as $_orm):
?>
			<tr>
				<td><?php echo $_orm->id; ?></td>
				<td><?php echo $_orm->email; ?></td>
				<td><?php echo $_orm->phone; ?></td>
				<td>
<?php 
					$_status = Arr::get($status_list, $_orm->status); 
					if ($_orm->status == 0) {
						$_status = '<b>'.$_status.'</b>';
					}
					echo $_status; 
?>
				</td>
				<td>
<?php 
					echo '<div class="btn-group">';
					
						if ($ACL->is_allowed($USER, $_orm, 'edit')) {
							echo HTML::anchor(str_replace('{id}', $_orm->id, $edit_tpl), '<i class="icon-edit"></i> '.__('Edit'), array(
								'class' => 'btn',
								'title' => __('Edit'),
							));
							echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
							echo '<ul class="dropdown-menu">';
							
								echo '<li>', HTML::anchor(str_replace('{id}', $_orm->id, $delete_tpl), '<i class="icon-remove"></i> '.__('Delete'), array(
									'class' => 'delete_button',
									'title' => __('Delete'),
								)), '</li>';
								
							echo '</ul>';
						}
					echo '</div>';
?>				
				</td>
			</tr>
<?php 
		endforeach;
?>
		</tbody>
	</table>
<?php
	if (empty($BACK_URL)) {
		$query_array = array(
		);
		$link = Route::url('modules', array(
			'controller' => $CONTROLLER_NAME['element'],
			'query' => Helper_Page::make_query_string($query_array),
		));
	} else {
		$link = $BACK_URL;
	}
	
	echo $paginator->render($link);

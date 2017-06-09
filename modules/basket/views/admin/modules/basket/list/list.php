<?php defined('SYSPATH') or die('No direct access allowed.'); 

	if (Request::current()->is_initial()) {
		echo View_Admin::factory('layout/breadcrumbs', array(
			'breadcrumbs' => $breadcrumbs
		));
	}

	if (empty($list)) {
		return;
	}

	$query_array = array(
		'basket' => $BASKET_ID,
	);
	if ( ! empty($BACK_URL)) {
		$query_array['back_url'] = $BACK_URL;
	}

	$query_array = Paginator::query(Request::current(), $query_array);
	$edit_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['basket'],
		'action' => 'edit',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$delete_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['basket'],
		'action' => 'delete',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
?>
	<table class="table table-bordered table-striped">
		<colgroup>
			<col class="span5">
			<col class="span1">
			<col class="span1">
			<col class="span2">
		</colgroup>
		<thead>
			<tr>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Cnt'); ?></th>
				<th><?php echo __('Price'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php 			
		foreach ($list as $_item):
?>
			<tr>
				<td><?php echo $_item['name']; ?></td>
				<td><?php echo $_item['count']; ?></td>
				<td><?php echo $_item['price']; ?></td>
				<td>
<?php 
					echo '<div class="btn-group">';
					
						echo HTML::anchor(str_replace('{id}', $_item['id'], $edit_tpl), '<i class="icon-edit"></i> '.__('Edit'), array(
							'class' => 'btn',
							'title' => __('Edit'),
						));
						echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
						echo '<ul class="dropdown-menu">';
						
							echo '<li>', HTML::anchor(str_replace('{id}', $_item['id'], $delete_tpl), '<i class="icon-remove"></i> '.__('Delete'), array(
								'class' => 'delete_button',
								'title' => __('Delete'),
							)), '</li>';
							
						echo '</ul>';
						
					echo '</div>';
?>				
				</td>
			</tr>
<?php 
		endforeach;
?>
		</tbody>
	</table>

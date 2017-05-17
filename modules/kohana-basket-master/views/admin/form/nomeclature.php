<?php defined('SYSPATH') or die('No direct access allowed.'); 

	$required = empty($required) ? array() : $required;
	$errors = empty($errors) ? array() : $errors;

	$controls = Form::hidden($field_1, $value_1, array(
		'id' => $field_1.'_field'
	));
	$controls .= '<div class="input-append input-nomenclature">'.Form::input($field_2, $value_2, array(
		'class' => 'input-xlarge',
		'readonly' => 'readonly',
		'id' => $field_2.'_field'
	));
	$controls .= HTML::anchor('#', __('Edit'), array(
		'class' => 'btn js-action-edit',
		'data-source' => $source,
	)).'</div>';
	
	echo View_Admin::factory('form/control', array(
		'field' => $field_2,
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls_class' => 'nomenclature-controls',
		'controls' => $controls,
	));

	echo View_Admin::factory('form/nomenclature/modal', array(
		'hidden_id' => $field_1.'_field',
		'input_id' => $field_2.'_field',
	));
?>
	<script type="text/javascript" src="<?php echo $ASSETS; ?>vendor/dynatable-0.3.1/jquery.dynatable.js"></script>
	<script type="text/javascript" src="<?php echo $ASSETS; ?>js/nomeclature.js"></script>


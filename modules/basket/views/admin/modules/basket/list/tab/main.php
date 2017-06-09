<?php defined('SYSPATH') or die('No direct access allowed.');

	$orm = $helper_orm->orm();
	$labels = $orm->labels();
	$required = $orm->required_fields();

	
/**** nomenclature_id/name ****/	
	
	echo View_Admin::factory('form/nomeclature', array(
		'field_1' => 'nomenclature_id',
		'value_1' => $orm->nomenclature_id,
		'field_2' => 'name',
		'value_2' => $orm->name,
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'source' => $source,
	));
	
/**** count ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'count',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::input('count', $orm->count, array(
			'id' => 'count_field',
			'class' => 'input-xxlarge',
		)),
	));
	
/**** price ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'price',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::input('price', $orm->price, array(
			'id' => 'price_field',
			'class' => 'input-xxlarge',
		)),
	));
	
/**** discount ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'discount',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::input('discount', $orm->discount, array(
			'id' => 'discount_field',
			'class' => 'input-xxlarge',
		)),
	));

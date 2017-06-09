<?php defined('SYSPATH') or die('No direct access allowed.');

	$orm = $helper_orm->orm();
	$labels = $orm->labels();
	$required = $orm->required_fields();


/**** id ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'id',
		'errors' =>	$errors,
		'labels' =>	$labels,
		'required' => $required,
		'controls' => Form::input('_id', $orm->id, array(
			'id' => 'id_field',
			'class' => 'input-xxlarge',
			'readonly' => 'readonly',
		)),
	));
	
/**** status ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'status',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::select('status', $status_list, (int) $orm->status, array(
			'id' => 'status_field',
			'class' => 'input-xxlarge',
		)),
	));
	
	
/**** email ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'email',
		'errors' =>	$errors,
		'labels' =>	$labels,
		'required' => $required,
		'controls' => Form::input('email', $orm->email, array(
			'id' => 'email_field',
			'class' => 'input-xxlarge',
		)),
	));
	
/**** phone ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'phone',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::input('phone', $orm->phone, array(
			'id' => 'phone_field',
			'class' => 'input-xxlarge',
		)),
	));
	
/**** user_id ****/
	
	echo View_Admin::factory('form/user', array(
		'field' => 'user_id',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'user' => $user,
	));
	

/**** text ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'text',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::textarea('text', $orm->text, array(
			'id' => 'text_field',
			'class' => 'text-area-clear',
		)),
	));	

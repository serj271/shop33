<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basket extends ORM_Base {

	protected $_table_name = 'catalog_basket';
	protected $_sorting = array('created' => 'DESC');
	protected $_deleted_column = 'delete_bit';

	protected $_has_many = array(
		'items' => array(
			'model' => 'basket_List',
			'foreign_key' => 'basket_id',
		),
	);
	
	public function labels()
	{
		return array(
			'id' => 'Order №',
			'user_id' => 'User',
			'email' => 'E-mail',
			'phone' => 'Phone',
			'text' => 'Details',
			'status' => 'Status',
		);
	}

	public function rules()
	{
		return array(
			'id' => array(
				array('digit'),
			),
			'user_id' => array(
				array('digit'),
			),
			'email' => array(
//				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('email'),
			),
			'phone' => array(
//				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('phone'),
			),
			'status' => array(
				array('digit'),
			),
		);
	}

	public function filters()
	{
		return array(
			TRUE => array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	
}

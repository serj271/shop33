<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basket_List extends ORM_Base {

	protected $_table_name = 'catalog_basket_list';
	protected $_sorting = array('basket_id' => 'ASC');
	protected $_deleted_column = 'delete_bit';

	protected $_belongs_to = array(
		'basket' => array(
			'model' => 'basket',
			'foreign_key' => 'basket_id',
		),
		'product' => array(
			'model' => 'product',
			'foreign_key' => 'product_id',
		),
	);
	
	public function labels()
	{
		return array(
			'basket_id' => 'Basket',
			'product_id' => 'Product',
//			'name' => 'Name',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'discount' => 'Discount',
		);
	}

	public function rules()
	{
		return array(
			'id' => array(
				array('digit'),
			),
			'basket_id' => array(
				array('not_empty'),
				array('digit'),
			),
			'product_id' => array(
				array('not_empty'),
				array('digit'),
			),
//			'name' => array(
//				array('not_empty'),
//				array('max_length', array(':value', 255)),
//			),
			'quantity' => array(
				array('not_empty'),
				array('digit'),
//				array('max_length', array(':value', 255)),
			),
			'price' => array(
//				array('not_empty'),
				array('numeric'),
//				array('max_length', array(':value', 255)),
			),
			'discount' => array(
				array('max_length', array(':value', 255)),
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

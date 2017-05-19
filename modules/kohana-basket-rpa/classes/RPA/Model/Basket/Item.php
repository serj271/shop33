<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model that reperensents a shopping basket item.
 * This model is essentialy just a pivot/link model between
 * the basket model and another entity that can be placed 
 * into the basket.  This class is responsible for the
 * quantity and the 
 *
 * - Adding items to the Shopping Basket
 * - Removing items from the Shopping Basket
 * - Retrieving items from the Shopping Basket
 * - Totaling the prices of items in the Shopping Basket
 *
 * @package    RPA/Basket
 * @author     RPA Design
 * @copyright  (c) 2012 RPA Communications By Design Ltd
 * @license    http://www.freebsd.org/copyright/freebsd-license.html
 */

class RPA_Model_Basket_Item extends ORM
{

	/**
	 * Kohana ORM relationship defintion, the basket item model belongs to
	 * a model basket object
	 * 
	 * @var 	array
	 */
	protected $_belongs_to = array('basket' => array());

	/**
	 * The item that this basket item represents.
	 * Must implement the Basket_Item interface.
	 * 
	 * @var 	 Interface_Basket_Item
	 */
	protected $_item = NULL;
	protected $_table_name='shopping_cart';

//================================================================================

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
				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('email'),
			),
			'phone' => array(
				array('not_empty'),
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



	/**
	 * Getter for the item property.
	 * 
	 * @return 	Interface_Basket_Item 	$item 	The item that this object acts as a wrapper for
	 */
	public function get_item()
	{
		return $this->_item;
	}

	/**
	 * Setter for the item property. The item must be set before any of
	 * the other functionality of the Model_Basket_Item class will work.
	 * 
	 * @param 	Interface_Basket_Item 	$item 	The item that this object will act as a wrapper for
	 */
	public function set_item(Interface_Basket_Item $item)
	{
		$this->_item = $item;
		$this->item_type = get_class($this->_item);
		$this->item_identifier = $this->_item->get_id();
	}

	/**
	 * Returns the net price of the item.
	 * The Net price is the net unit price * quantity.
	 * 
	 * @return 	float 	The net price of the item
	 */
	public function net_price()
	{
		$item = $this->get_item();
		$net_price = $item->net_unit_price() * $this->quantity;
		return (float)round($net_price, 2);
	}

	/**
	 * Returns the gross price of the item.
	 * The Gross price is the (net price * quantity) + (tax amount * quantity).
	 * 
	 * @return 	float 	The gross price of the item
	 */
	public function gross_price()
	{
		$gross_price = $this->net_price() + $this->tax_amount();
		return (float)round($gross_price, 2);
	}

	/**
	 * Returns the amount of tax for this item.
	 * The amount of tax = (net price * quantity) * tax rate.
	 * 
	 * @return 	float 	The tax amount for the item
	 */
	public function tax_amount()
	{
		$item = $this->get_item();
		$tax_amount = ($item->net_unit_price() * $this->quantity) * $item->tax_rate();
		return (float)round($tax_amount, 2);
	}

	/**
	 * extension of ORM _load_values method, this is called each time the data for
	 * this object is retrieved from the DB.  This extension adds extra functionality
	 * to instatiate the item object each time the basket item is loaded.
	 * 
	 * @param   array 				$values 	 Values to load
	 * @return 	Model_Basket_Item
	 */
	public function _load_values(array $values)
	{
		$basket_item = parent::_load_values($values);

		if($basket_item->item_type !== NULL AND $basket_item->item_identifier != NULL)
		{	
			// instatiate the item
			$item = call_user_func($basket_item->item_type.'::find_by_id', $basket_item->item_identifier);
			$basket_item->set_item($item);
		}

		return $basket_item;
	}

}
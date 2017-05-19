<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model that reperensents a user's shopping basket.
 * Covers the following functionality.
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

class RPA_Model_Basket extends ORM
{

	/**
	 * Kohana ORM relationship defintion, the basket model has many basket
	 * item children
	 * 
	 * @var array
	 */
	protected $_has_many = array('basket_items' => array());

//================================================================================

	/**
	 * Adds an item to the shopping basket
	 * 
	 * @param 	Model_Basket_Item 	$item 	The item to be added
	 */
	public function add_item(Interface_Basket_Item $item, $quantity = 1)
	{
		if(!$this->loaded())
		{	
			$this->save();
		}

		// check if the item is already in the basket
		$basket_item = $this->get_basket_item($item->get_id());
		if($basket_item instanceOf Model_Basket_Item)
		{
			// item is already in the basket so just increase the quantity
			$basket_item->quantity += $quantity;
		}
		else
		{
			$basket_item = new Model_Basket_Item;
			$basket_item->basket_id = $this->id;
			$basket_item->set_item($item);
			$basket_item->quantity = $quantity;
		}

		$basket_item->save();
	}

	/**
	 * Removes an item from the shopping basket
	 * 
	 * @param 	mixed 	$item 	Either a Model_Basket_Item object or the ID of the item to be removed
	 */
	public function remove_item($identifier)
	{
		$item = $this->get_basket_item($identifier);
		if(!$item instanceOf Model_Basket_Item)
		{
			// the item doesn't exist
			throw new Basket_Exception('Attempted to remove item with an ID of :id but the item does not exist', array(':id' => $id));
		}	

		$item->delete();
	}

	/**
	 * Removes all items from the shopping basket
	 */
	public function remove_all_items()
	{
		$basket_items = $this->get_all_basket_items();

		foreach($basket_items as $basket_item)
		{
			$basket_item->delete();
		}	
	}

	/**
	 * Returns the basket item associated with the specified idnetifier.
	 * 
	 * @return 	Model_Basket_Item 	The item associated with the specified identifier
	 */
	public function get_basket_item($identifier)
	{
		$basket_items = $this->get_all_basket_items();
		return Arr::get($basket_items, $identifier);
	}

	/**
	 * Returns all items currently in the shopping basket indexed by the
	 * item identifier.
	 * 
	 * @return 	Iterator 	A collection of Model_Basket_Item objects
	 */
	public function get_all_basket_items()
	{
		$indexed_basket_items = array();
		$basket_items = $this->basket_items->find_all();
		
		foreach($basket_items as $basket_item)
		{
			$identifier = $basket_item->item_identifier;
			$indexed_basket_items[$identifier] = $basket_item;
		}

		return $indexed_basket_items;
	}

	/**
	 * Returns the number of items currently in the shopping basket
	 * 
	 * @return 	int 	The number of items currently in the basket
	 */
	public function item_count()
	{
		return count($this->get_all_basket_items());
	}

	/**
	 * Returns the net total of the all of the items currently in the basket.
	 * Net total = total without tax.
	 * 
	 * @return 	float 	The net total of the items in the basket
	 */
	public function net_total()
	{
		$net_total = 0;
		$basket_items = $this->get_all_basket_items();

		foreach($basket_items as $basket_item)
		{
			$net_total += $basket_item->net_price();
		}	

		return (float)$net_total;
	}

	/**
	 * Returns the gross total of the all of the items currently in the basket.
	 * Gross total = total + tax.
	 * 
	 * @return 	float 	The gross total of the items in the basket
	 */
	public function gross_total()
	{
		$gross_total = 0;
		$basket_items = $this->get_all_basket_items();

		foreach($basket_items as $basket_item)
		{
			$gross_total += $basket_item->gross_price();
		}	

		return (float)$gross_total;
	}

	/**
	 * change the quantity of the item specified by identifier
	 * 
	 * @param  	string 	$identifer 	The identifier of the object
	 * @param  	int 	$quantity  	the new quantity value
	 * @return 	void
	 */
	public function update_quantity($identifer, $quantity)
	{
		$basket_item = $this->get_basket_item($identifer);

		$basket_item->quantity = $quantity;
		$basket_item->save();
	}

}
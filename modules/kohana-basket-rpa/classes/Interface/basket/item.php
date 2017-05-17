<?php
/**
 * Describes the public interface of an item that is 'basketable'.
 * Any object that needs to be put into the basket must implement 
 * this interface. Usually the Model_Product class would implement
 * this interface so that you could place products in the basket.
 * 
 * @package    RPA/Basket
 * @author     RPA Design
 * @copyright  (c) 2012 RPA Communications By Design Ltd
 * @license    http://www.freebsd.org/copyright/freebsd-license.html
 */

Interface Interface_Basket_Item
{
	/**
	 * Finds the item for the specified unique identifier.
	 * 
	 * @param  	mixed 	$identifier 	The unique identifier of the item to retrieve
	 * @return 	Interface_Basket_Item 	An object of unspecified type that implements this interface  
	 */
	public static function find_by_id($identifier);

	/**
	 * Returns the unique identifer of the item.
	 * Usually the DB Primary Key.
	 * 
	 * @return 	mixed 	The unique identifier of the item
	 */
	public function get_id();

	/**
	 * Returns the net price of a single item.
	 * 
	 * @return 	float 	The net unit price of the item
	 */
	public function net_unit_price();

	/**
	 * Returns the tax rate for this item.
	 * 
	 * @return 	float 	The tax rate for the item
	 */
	public function tax_rate();

	/**
	 * Returns the user friendly description for the item.
	 * 
	 * @return 	string 	The description of the item
	 */
	public function description();

}
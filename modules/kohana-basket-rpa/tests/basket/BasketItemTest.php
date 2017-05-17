<?php
/**
 * Tests for the Basket Item Model
 * 
 * @package    RPA/Basket
 * @author     RPA Design
 * @copyright  (c) 2012 RPA Communications By Design Ltd
 * @license    http://www.freebsd.org/copyright/freebsd-license.html
 */

class RPA_BasketItemTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Returns a model basket object that can be used for
	 * testing.
	 * 
	 * @return 	Model_Basket_Item 	A model basket object to be used for testing
	 */
	private function get_basket_item()
	{
		$basket_item = new Model_Basket_Item;
		$basket_item->set_item(new RPA_Test_Basket_Item);
		$basket_item->quantity = 1;

		return $basket_item;
	}

	/**
	 * Tests the [Model_Basket_Item::gross_price()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_net_price()
	{
		$basket_item = $this->get_basket_item();
		$basket_item->quantity = 3;

		$this->assertSame($basket_item->net_price(), 14.97);
	}

	/**
	 * Tests the [Model_Basket_Item::gross_price()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_gross_price()
	{
		$basket_item = $this->get_basket_item();

		$this->assertSame($basket_item->gross_price(), 5.99);
	}

	/**
	 * Tests the [Model_Basket_Item::gross_price()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_tax_amount()
	{
		$basket_item = $this->get_basket_item();

		$this->assertSame($basket_item->tax_amount(), 1.0);
	}

}
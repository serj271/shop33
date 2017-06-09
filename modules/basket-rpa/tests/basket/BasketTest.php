<?php
/**
 * Unit Tests for the Basket Model
 * 
 * @package    RPA/Basket
 * @author     RPA Design
 * @copyright  (c) 2012 RPA Communications By Design Ltd
 * @license    http://www.freebsd.org/copyright/freebsd-license.html
 */

class RPA_BasketTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Returns a model basket object that can be used for
	 * testing.
	 * 
	 * @return 	Model_Basket_Item 	A model basket object to be used for testing
	 */
	private function get_item()
	{
		return new RPA_Test_Basket_Item;
	}

	/**
	 * Tests that you can add a new item to the basket.
	 * 
	 * @return  void
	 */
	public function test_add_new_item()
	{
		$basket = new Model_Basket;

		$item = $this->get_item();
		$basket->add_item($item);

		$this->assertSame($basket->item_count(), 1);
	}

	/**
	 * Tests that you can add multiple, different items to the basket.
	 * 
	 * @return  void
	 */
	public function test_add_multiple_items()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$item_1->identifier = 1;
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$item_2->identifier = 2;
		$basket->add_item($item_2);

		$item_3 = $this->get_item();
		$item_3->identifier = 3;
		$basket->add_item($item_3);

		$this->assertSame($basket->item_count(), 3);
	}

	/**
	 * Tests that if you add an existing item to the basket, the item is not
	 * duplicated
	 * 
	 * @return  void
	 */
	public function test_add_existing_item_does_not_duplicate()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$basket->add_item($item_2);

		$this->assertSame($basket->item_count(), 1);
	}

	/**
	 * Tests that if you add an existing item to the basket, the existing
	 * item's quantity is increased by the specified amount.
	 * 
	 * @return  void
	 */
	public function test_add_existing_item_increases_quantity()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$basket->add_item($item_2, 2);

		$basket_item = $basket->get_basket_item($item_1->get_identifier());
		$this->assertSame((int)$basket_item->quantity, 3);
	}

	/**
	 * Tests the [Model_Basket::get_basket_item] method returns the correct item
	 * 
	 * @return void
	 */
	public function test_get_basket_item()
	{
		$basket = new Model_Basket;

		$item = $this->get_item();
		$item->identifer = 1;
		$basket->add_item($item);

		$basket_item = $basket->get_basket_item($item->get_identifier());

		$this->assertSame((string)$item->get_identifier(), (string)$basket_item->item_identifier);
	}

	/**
	 * Tests the [Model_Basket::get_all_basket_items] method returns the correct
	 * number of items
	 * 
	 * @return void
	 */
	public function test_get_all_basket_items()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$item_1->identifier = 1;
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$item_2->identifier = 2;
		$basket->add_item($item_2);

		$item_3 = $this->get_item();
		$item_3->identifier = 3;
		$basket->add_item($item_3);

		$this->assertSame($basket->item_count(), 3);
	}

	/**
	 * Tests the [Basket::remove_item()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_remove_item()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$item_2->identifier = 2;
		$basket->add_item($item_2);

		$basket->remove_item($item_1->get_identifier());

		$this->assertSame($basket->item_count(), 1);
	}

	/**
	 * Tests the [Basket::remove_all_items()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_remove_all_items()
	{
		$basket = new Model_Basket;

		$item_1 = $this->get_item();
		$basket->add_item($item_1);

		$item_2 = $this->get_item();
		$item_2->identifier = 2;
		$item_2->quantity = 6754;
		$basket->add_item($item_2);

		$item_3 = $this->get_item();
		$item_3->identifier = 3;
		$item_3->quantity = 2446754;
		$basket->add_item($item_3);

		$item_4 = $this->get_item();
		$item_4->quantity = 2498759486754;
		$basket->add_item($item_4);

		$basket->remove_all_items();

		$this->assertSame($basket->item_count(), 0);
	}

	/**
	 * Tests the [Basket::net_total()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_net_total()
	{
		$basket = new Model_Basket;

		$item = $this->get_item();
		$basket->add_item($item, 6);

		$this->assertSame($basket->net_total(), 29.94);
	}

	/**
	 * Tests the [Basket::gross_total()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_gross_total()
	{
		$basket = new Model_Basket;

		$item = $this->get_item();
		$basket->add_item($item, 4);

		$this->assertSame($basket->gross_total(), 23.95);
	}

	/**
	 * Tests the [Basket::update_quantity()] method works as expected.
	 * 
	 * @return  void
	 */
	public function test_update_quantity()
	{
		$basket = new Model_Basket;

		$item = $this->get_item();
		$basket->add_item($item);

		$basket->update_quantity($item->get_identifier(), 5);
		$basket_item = $basket->get_basket_item($item->get_identifier());

		$this->assertSame((int)$basket_item->quantity, 5);
	}

}
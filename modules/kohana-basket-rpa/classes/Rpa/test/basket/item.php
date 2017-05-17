<?php
/**
 * This is a mock 'basketable' class that is used for testing purposes only
 */
class RPA_Test_Basket_Item implements Interface_Basket_Item
{

	public $identifier = 999;
	public $net_unit_price = 4.99;
	public $tax_rate = 0.2;
	public $description = 'A Test Item';
	
	public static function find_by_identifier($identifier)
	{
		$item = new self;
		$item->identifier = $identifier;

		return $item;
	}	

	public function get_identifier()
	{
		return $this->identifier;
	}

	public function net_unit_price()
	{
		return $this->net_unit_price;
	}


	public function tax_rate()
	{
		return $this->tax_rate;
	}


	public function description()
	{
		return $this->description;
	}

}
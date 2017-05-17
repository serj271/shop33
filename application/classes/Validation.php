<?php defined('SYSPATH') OR die('No direct script access.');

class Validation extends Kohana_Validation {


    public static function lt($sale_price, $price){//array
	return $sale_price <= $price[0];
    }

}

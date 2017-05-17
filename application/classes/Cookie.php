<?php defined('SYSPATH') or die('No direct script access.');
class Cookie extends Kohana_Cookie {
    public static $foo ='foo';
    public static $encryption  = 'default';
    
    public static function encrypt($name, $value, $expiration = NULL)
    {
	$value = Encrypt::instance(Cookie::$encryption)->encode((string) $value);
	parent::set($name, $value, $expiration);
    
    
    }
    public static function decrypt($name, $default = NULL)
    {
	if ($value == parent::get($name, NULL))
	{
	    $value = Encrypt::instance(Cookie::$encrypt)->decode($value);
	
	}
	return isset($value) ? $value : $default;

    }

} // End 

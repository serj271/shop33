<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Asia/Yekaterinburg');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));
spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}
ini_set('display_errors',1);
error_reporting(-1);
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/shop33/',
	'charset'    => 'utf-8',
	'index_file' => false,
	'errors'=>FALSE,
//	'errors'     =>true,
));


/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   	=> MODPATH.'database-3.3-master',   // Database access
	 'mysqli'   	=> MODPATH.'kohana-3.3-mysqli-master',   // Database access
	 'image'     	=> MODPATH.'image',      // Image manipulation
	 'minion'     	=> MODPATH.'minion-3.3-master',     // CLI Tasks
	 'orm'        	=> MODPATH.'orm-3.3-master',        // Object Relationship Mapping
	 'autoload'	=>MODPATH.'autoload',
	 'kostache'	=>MODPATH.'KOstache-master',
//	 'basket'	=>MODPATH.'kohana-basket-master',
	 'basket'	=>MODPATH.'kohana-basket-rpa',
	 'pagination'	=>MODPATH.'kohana-pagination',
	'breadcrumbs'=> MODPATH.'kohana-breadcrumbs-master',
	'catalog-shop'=> MODPATH.'catalog-shop',
	'message'=> MODPATH.'kohana-message-master',
	'tree'=> MODPATH.'kohana-tree-from-array-master',
	 'ecommerce'	=> MODPATH.'kohana-oz-ecommerce-3.3-master',        // Object Relationship Mapping
	 'unittest'   	=> MODPATH.'unittest',   // Unit testing
	 'userguide'  	=> MODPATH.'userguide',  // User guide and API documentation
	 'datalog'  	=> MODPATH.'kohana-datalog',  // 
	));

/**
 * Cookie Salt
 * @see  http://kohanaframework.org/3.3/guide/kohana/cookies
 * 
 * If you have not defined a cookie salt in your Cookie class then
 * uncomment the line below and define a preferrably long salt.
 */
// Cookie::$salt = NULL;
$mysalt = 'ksfjehnfkekgjirelkmgebhjfbewgrk848k^&^Tiuuiuiuuh#@_';
Cookie::$salt= 'mysalt';
Cookie::$expiration = Date::WEEK; //Date::MONTH * 3
//Cookie::$path = '/admin/'; //for directory admin
//Cooki::$domain = 'kohana3.ru';
//Cookie::$secure = TRUE; // for use only https://
//Cookie::$httponly = TRUE //for not use froom javascript
//Cookie::set($key,$value)
//Cookie::get($key)
//Cookie::delete($key)
Session::$default ='cookie';
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
if( ! Route::cache())
{ 
 
/*Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'welcome',
		'action'     => 'index',
	));
*/
Route::set('welcome', 'welcome(/<action>)')
	->defaults(array(
		'controller' => 'Welcome',
		'action'     => 'index',
	));


Route::set('home', '(/<action>/(<pole>(/<id>(/<overflow>))))')
	->defaults(array(
		'controller' => 'Home',
		'action'     => 'index',
	));

Route::set('product', 'product(/<item_uri>)', array(
	'item_uri'=>'.*'
))
	->defaults(array(
		'controller' => 'product',
		'action'     => 'index',
		'index_file' =>''
	));

Route::set('user', 'user(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'user',
		'controller' => 'main',
		'action'     => 'index',
	));


Route::set('page', 'useradmin/users(/index/<pole>/<page>)',array('page'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'users',
		'action'     => 'index',
	));

Route::set('useradmin', 'useradmin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'main',
		'action'     => 'index',
	));


Route::set('basket', 'basket(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'basket',
		'controller' => 'main',
		'action'     => 'index',
	));


/*Route::set('product', 'product(/<page>)', array(
	'page'=>'.*'
))
	->defaults(array(
		'controller' => 'product',
		'action'     => 'index',
		'index_file' =>''
	));

*/






//    Route::cache(TRUE);
}








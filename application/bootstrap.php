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
#if (isset($_ENV['KOHANA_ENV']))
#{
#	Kohana::$environment = $_ENV['KOHANA_ENV'];
#}

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
	'profile'	=> Kohana::$environment !== Kohana::PRODUCTION,
	'caching'	=> Kohana::$environment === Kohana::PRODUCTION,
	'errors' 	=> Kohana::$environment !== Kohana::PRODUCTION

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
	'mysqli'   	=> MODPATH.'mysqli',   // Database access
	'image'     	=> MODPATH.'image',      // Image manipulation
	'minion'     	=> MODPATH.'minion-3.3-master',     // CLI Tasks
	'orm'        	=> MODPATH.'orm-3.3-master',        // Object Relationship Mapping
	'autoload'	=>MODPATH.'autoload',
	'kostache'	=>MODPATH.'KOstache-master',
	'sprig'	=>MODPATH.'sprig',
	'comments'	=>MODPATH.'comments',
	'menu'        	=> MODPATH.'menu', 
	'captcha'        	=> MODPATH.'captcha',  	
//	'blog'	=>MODPATH.'kohana-blog-master',
	'pagination'	=>MODPATH.'pagination',
	'breadcrumbs'=> MODPATH.'breadcrumbs',
	'catalog-shop'=> MODPATH.'catalog-shop',
	'message'=> MODPATH.'message',
	'B8'=> MODPATH.'B8',
//	'tree'=> MODPATH.'kohana-tree-from-array-master',
	 'ecommerce'	=> MODPATH.'oz-ecommerce',        // Object Relationship Mapping
#	 'unittest'   	=> MODPATH.'unittest',   // Unit testing
#	 'userguide'  	=> MODPATH.'userguide',  // User guide and API documentation
//	 'datalog'  	=> MODPATH.'datalog',  // 
	'image' => MODPATH.'image',  // Image manipulation
	'imagefly' => MODPATH.'imagefly',
	'imagemagick' => MODPATH.'imagemagick',  // Image manipulation
	 'media'		=> MODPATH.'media',
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
Session::$default ='native';
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
if( ! Route::cache())
{ 
 
 /* 	
Route::set('img', 'img(/<action>)')
    ->defaults(array(
        'controller' => 'Welcome',
        'action' => 'index',
    )); */	
 
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

Route::set('product', 'product(/<action>(/<item_uri>))', array(
	'item_uri'=>'.*'
))
	->defaults(array(
		'directory' =>'product',
		'controller' => 'main',
		'action'     => 'index',
		'index_file' =>''
	));

Route::set('user', 'user(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'user',
		'controller' => 'main',
		'action'     => 'index',
	));

/* 
Route::set('page', 'useradmin/users(/index/<pole>/<page>)',array('page'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'users',
		'action'     => 'index',
	)); */

Route::set('useradmin', 'useradmin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'main',
		'action'     => 'index',
	));
/* 
Route::set('adminmodel', 'admin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'admin',
		'controller' => 'main',
		'action'     => 'index',
	)); */
	
Route::set('basket', 'basket(/<action>(/<id>))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'basket',
		'controller' => 'main',
		'action'     => 'index',
	));
Route::set('admin/basket', 'admin/basket(/<action>(/<id>))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'admin',
		'controller' => 'basket',
		'action'     => 'index',
	));
/*
Route::set('blog/stats', 'blog/stats/<action>(/<limit>)', array(
		'limit' => '\d+',
	))->defaults(array(
		'directory'  => 'blog',
		'controller' => 'stats',
	));
*/
 
Route::set('comments', 'comments/<action>(/<id>(/<page>))(<format>)', array(
		'id'     => '\d+',
		'page'   => '\d+',
		'format' => '\.\w+',
	))->defaults(array(
		'directory' =>'comments',
		'controller' => 'main',
//		'group'      => 'default',
		'format'     => '.json',
	));

Route::set('comment', 'comment(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'comment',
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
/* 
Route::set('media', 'media/<action>(/<path>)', array(
        'path' => '.*?',
    ))
    ->defaults(array(
        'controller' => 'media',
        'action' => 'index',
    )); */
/* 
Route::set('media', '<type>/<file>', array('type' => 'img|css|js', 'file' => '.+.(?:jpe?g|png|gif|css|js)'))
     ->defaults(array(
          'controller' => 'media',
          'action'     => 'index',
     ));

 */
	/* Error routes */
	Route::set('403', '<error>', array('error' => '403'))
		->defaults(array(
			'controller' => 'error',
			'action' => 'index'
		));
	Route::set('404', '<error>', array('error' => '404'))
		->defaults(array(
			'controller' => 'error',
			'action' => 'index'
		));
	Route::set('500', '<error>', array('error' => '500'))
		->defaults(array(
			'controller' => 'error',
			'action' => 'index'
		));


	Route::cache(Kohana::$environment === Kohana::PRODUCTION);
}
/*
if ( ! defined('SUPPRESS_REQUEST'))
{
//	*
//	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
//	 * If no source is specified, the URI will be automatically detected.
	
	$request = Request::instance();
	$request = Request::factory('error');
	try {
		 Attempt to execute the response
		 $request->execute();
	}

	Catch errors

	catch (ReflectionException $e) {

		Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

		if ( Kohana::$environment === Kohana::DEVELOPMENT ) {

			throw $e;
		}

		$request->response = Request::factory('404')->execute();
	}
	catch (Exception404 $e) {

		Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

		if ( Kohana::$environment === Kohana::DEVELOPMENT ) {
			throw $e;
		}
		$request = Request::instance();
		$request->response = Request::factory('404')->execute();
	}
	catch (Kohana_Request_Exception $e) {

		Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

		if ( Kohana::$environment === Kohana::DEVELOPMENT ) {
			throw $e;
		}

		$request->response = Request::factory('404')->execute();
	}
	catch (Exception $e) {

		Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

		if ( Kohana::$environment === Kohana::DEVELOPMENT ) {

			throw $e;
		}
		 
		$request->response = Request::factory('500')->execute();
	}

	$request->response AND print $request->send_headers()->response;
}
*/






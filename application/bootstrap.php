<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/London');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_GB.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Set Kohana::$environment if $_ENV['KOHANA_ENV'] has been supplied.
 * 
 */
if (isset($_ENV['KOHANA_ENV']))
{
	Kohana::$environment = $_ENV['KOHANA_ENV'];
}
/*
 *check if ENV var has been defined in apache vhost
 */
else if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = $_SERVER['KOHANA_ENV'];
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url	  path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"	     index.php
 * - string   charset	  internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory		     APPPATH/cache
 * - boolean  errors	  enable or disable error handling		     TRUE
 * - boolean  profile	  enable or disable internal profiling		     TRUE
 * - boolean  caching	  enable or disable internal caching		     FALSE
 */
Kohana::init(array(
	'base_url'	=> '/',
	'index_file'	=> FALSE,
	'profile'	=> Kohana::$environment !== Kohana::PRODUCTION,
	'caching'	=> Kohana::$environment === Kohana::PRODUCTION,
	'errors' 	=> Kohana::$environment !== Kohana::PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'admin'		=> MODPATH.'admin',
	'base'		=> MODPATH.'base',
	'database'	=> MODPATH.'database',	// Database access
	'orm'		=> MODPATH.'orm',	// Object Relationship Mapping
	'auth'		=> MODPATH.'auth',	// Basic authentication
	'oauth'		=> MODPATH.'oauth',	// OAuth authentication
	'media'		=> MODPATH.'media',	// Media caching
	'cache'		=> MODPATH.'cache',	// Caching with multiple backends
	'pagination'	=> MODPATH.'pagination',// Paging of results
	'message'	=> MODPATH.'message',
	'image'		=> MODPATH.'image',	// Image manipulation
	'imagemagick-driver' => MODPATH.'imagemagick-driver',
	// 'userguide'	=> MODPATH.'userguide', // User guide and API documentation
	// 'codebench'	=> MODPATH.'codebench', // Benchmarking tool
	// 'unittest'	=> MODPATH.'unittest',	// Unit testing
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
if ( !Route::cache()){

	/* User & Auth routes */
	Route::set('user', 'user(/<action>)(/<id>)')
		->defaults(array(
			'directory' => 'auth',
			'controller' => 'user',
			'action' => 'index'
		));
	Route::set('auth-openid', 'openid(/<action>)(/<id>)')
		->defaults(array(
			'directory' => 'auth',
			'controller' => 'openid',
			'action' => 'index'
		));
	Route::set('auth-oauth', 'oauth/<controller>(/<action>)')
		->defaults(array(
			'directory' => 'auth/oauth',
			'action' => 'index'
		));

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

	/* Default route */
	Route::set('default', '(<controller>(/<action>(/<id>)))')
		->defaults(array(
			'controller' => 'home',
			'action'     => 'index',
		));

	// Cache the routes in production
	Route::cache(Kohana::$environment === Kohana::PRODUCTION);
}

if ( ! defined('SUPPRESS_REQUEST'))
{
	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	$request = Request::instance();

	try {
		 // Attempt to execute the response
		 $request->execute();
	}

	/* Catch errors */

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

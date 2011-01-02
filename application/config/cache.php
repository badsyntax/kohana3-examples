<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'file'	  => array
	(
		'driver'		=> 'file',
		'cache_dir'		=> 'application/cache/',
		'default_expire'	=> 3600,
	),
	// Cache key used for storing the database config
	'config_cache_key' => 'database_config'
);

<?php defined('SYSPATH') or die('No direct access allowed.');

return 
	Kohana::$environment == Kohana::DEVELOPMENT
	? array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'username'   => 'root',
				'password'   => '',
				'persistent' => FALSE,
				'database'   => 'example_dev',
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		)
	)
	: array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'username'   => 'root',
				'password'   => '',
				'persistent' => FALSE,
				'database'   => 'example_live',
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		)
	);

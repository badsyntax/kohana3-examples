<?php defined('SYSPATH') or die('No direct access allowed.');

return 
	Kohana::$environment == Kohana::DEVELOPMENT
	/* DEVELOPMENT database */
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
	/* PRODUCTION database */
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

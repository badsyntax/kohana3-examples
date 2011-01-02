<?php defined('SYSPATH') or die('No direct access allowed.');

return 
	Kohana::$environment == Kohana::PRODUCTION
	/* PRODUCTION database */
	? array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'username'   => '',
				'password'   => '',
				'persistent' => FALSE,
				'database'   => 'kohana3-examples_live',
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		)
	)
	/* DEVELOPMENT database */
	: array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'username'   => '',
				'password'   => '',
				'persistent' => FALSE,
				'database'   => 'kohana3-examples_dev',
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		)
	);

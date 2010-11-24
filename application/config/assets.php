<?php defined('SYSPATH') or die('No direct access allowed.');
/*
 * Site assets configuration
 */
return array(
	'default' => array(
		'style' => array(
			'media/css/base.css',
			'media/css/style.css'
		),
		'script' => array(
			'media/js/jquery-1.4.4.min.js',
			'media/js/global.js'
		)
	),
	'mobile' => array(
		'style' => array(
			'media/css/mobile/jquery.mobile-1.0a2.css',
			'media/css/mobile_style.css'
		),
		'script' => array(
			'media/js/jquery-1.4.4.min.js',
			'media/js/global.mobile.js',
			'media/js/jquery.mobile-1.0a2.min.js'
		)
	),
);

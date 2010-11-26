<?php defined('SYSPATH') or die('No direct script access.');

/* Admin routes */
Route::set('admin-home', 'admin')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'home',
		'action' => 'index'
	));
Route::set('admin', 'admin/<controller>(/<action>)(/<id>)')
	->defaults(array(
		'action' => 'index',
		'directory' => 'admin'
	));

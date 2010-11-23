<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * Session configurations
 * see http://kohanaframework.org/guide/using.sessions#adapters
 */

// use the cookie adapter
return array(
	'cookie' => array(
		'name'		=> 'session',
		'encrypted'	=> FALSE,
		'lifetime'	=> 0 // session will exire when browser is closed
	),
);

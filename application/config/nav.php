<?php defined('SYSPATH') or die('No direct script access.');
 
$links = array(
	'' => 'Home',
	'contact' => 'Contact',
	'general' => 'General',
	str_replace('://', 'http://mobile.', URL::base(TRUE, '')) => 'Mobile',
	'admin' => 'Admin'
);

$links = Auth::instance()->logged_in()
	? array_merge($links, array(
		'user/profile' => 'Profile',
		'user/signout' => 'Sign out'
		))
	: array_merge($links, array(
		'user/signin' => 'Sign in',
		'user/signup' => 'Sign up'
		));

if (Kohana::$environment === Kohana::DEVELOPMENT){

	$links['#profiler'] = 'Profiler';
}

return array(
	'links' => $links
);

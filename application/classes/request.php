<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request {

	static public $is_mobile = FALSE;

	public static function instance( & $uri = TRUE)
	{
		if ( ! Request::$instance AND ! Kohana::$is_cli )
		{
			// Detect mobile environment from HTTP HOST
                	Request::$is_mobile = !!strstr(URL::base(TRUE, TRUE), '//mobile.');
		}

		return parent::instance($uri);
	}

} // End Request

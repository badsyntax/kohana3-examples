<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/controller/oauth/base.php
 */

abstract class Controller_Auth_OAuth_Base extends Controller_Base {

	// OAuth
	protected $provider;
	protected $consumer;
	protected $token;
	protected $cookie;

	protected $config;

	public function before()
	{
		parent::before();

		// The user is already logged in
		if (Auth::instance()->logged_in())
		{
			Request::instance()->redirect('');
		}

		// Load the configuration for this provider
		$this->config = Kohana::config('oauth.'.$this->provider);

		// Create a consumer from the config
		$this->consumer = OAuth_Consumer::factory($this->config);

		// Load the provider
		$this->provider = OAuth_Provider::factory($this->provider);

		if ($token = Cookie::get($this->cookie))
		{
			// Get the token from storage
			$this->token = unserialize($token);
		}
	}

}

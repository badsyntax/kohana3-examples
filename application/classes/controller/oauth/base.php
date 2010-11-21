<?php defined('SYSPATH') or die('No direct script access.');
/*
 * concepts and code taken from https://github.com/GeertDD/kohanajobs
 */

abstract class Controller_OAuth_Base extends Controller_Base {

	// OAuth
	protected $provider;
	protected $consumer;
	protected $token;
	protected $cookie;

	protected $config;

	public function before()
	{
		parent::before();

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

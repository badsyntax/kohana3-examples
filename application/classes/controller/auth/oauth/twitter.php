<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Adapted from https://github.com/GeertDD/kohanajobs/raw/master/application/classes/controller/oauth/twitter.php
 */

class Controller_Auth_OAuth_Twitter extends Controller_Auth_OAuth_Base {

	// OAuth
	protected $provider = 'twitter';
	protected $cookie = 'oauth_token_twitter';

	public function action_index()
	{
		$this->request->redirect('');
	}

	public function action_signin()
	{
		// We will need a callback URL for the user to return to
		$callback = URL::site($this->request->uri(array('action' => 'complete')), Request::$protocol);

		// Add the callback URL to the consumer
		$this->consumer->callback($callback);

		// Get a request token for the consumer
		$token = $this->provider->request_token($this->consumer);

		// Store the request token
		Cookie::set($this->cookie, serialize($token));

		// Redirect to the provider's login page
		$this->request->redirect($this->provider->authorize_url($token));
	}

	public function action_complete()
	{
		if ($this->token AND $this->token->token !== Arr::get($_GET, 'oauth_token'))
		{
			// Delete the token, it is not valid
			Cookie::delete($this->cookie);

			// Send the user back to the beginning
			$this->request->redirect($this->request->uri(array('action' => 'index')));
		}

		// Get the verifier
		$verifier = Arr::get($_GET, 'oauth_verifier');

		// Store the verifier in the token
		$this->token->verifier($verifier);

		// Exchange the request token for an access token
		$this->token = $this->provider->access_token($this->consumer, $this->token);

		// Store the access token
		Cookie::set($this->cookie, serialize($this->token));

		// At this point, we need to retrieve a unique twitter id for the user.
		// http://apiwiki.twitter.com/Twitter-REST-API-Method%3A-account%C2%A0verify_credentials
		// @todo try/catch?
		$response = OAuth_Request::factory('resource', 'GET', 'http://api.twitter.com/1/account/verify_credentials.json')
			->param('oauth_consumer_key', Kohana::config('oauth.twitter.key'))
			->param('oauth_token', $this->token)
			->sign(OAuth_Signature::factory('HMAC-SHA1'), $this->consumer, $this->token)
			->execute();
		$response = json_decode($response);

		if ( ! $twitter_id = (int) $response->id)
			exit('error');

		$twitter_name = $response->screen_name;
		$twitter_email = $twitter_name . '@twitter.com';
		$twitter_name .= '.twitter';

		// Check whether the twitter user exists in our users table
		$user = ORM::factory('user')
			->where('oauth_provider', '=', 'twitter')
			->where('oauth_id', '=', $twitter_id)
			->find();

		// If not, store the new email (as a new user).
		if ( ! $user->loaded())
		{
			// Add user
			$user->oauth_id = $twitter_id;
			$user->oauth_provider = 'twitter';
			$user->username = $twitter_name;
			$user->email = $twitter_email;
			$user->save();

			// Give user the "login" and "user" role
			$user->add('roles', ORM::factory('role', array('name' => 'login')));
			// @todo postpone give "user" role until after user completes the email field in his profile?
		
			Auth::instance()->force_login($user);

			$this->request->redirect('auth/profile');
		}

		Auth::instance()->force_login($user);

		$this->request->redirect('');
	}

} // End Controller Oauth Twitter

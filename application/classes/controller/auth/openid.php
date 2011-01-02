<?php defined('SYSPATH') or die('No direct script access.');
/*
 * This is a Kohana3 ported version of the php-openid example consumer files 
 * see https://github.com/openid/php-openid/tree/master/examples/consumer/
 */

class Controller_Auth_OpenID extends Controller_Base {

	protected $store_path = '/tmp/_php_consumer_test';

	public function before()
	{
		parent::before();
		
		// Ensure this script has permission to create the store path
		if (!file_exists($this->store_path) && !@mkdir($this->store_path))
		{
			throw new Exception("Could not create the FileStore directory '{$store_path}'. Please check the effective permissions.");
		}

		// Set the include path to the openid directory
		ini_set('include_path', 'application/vendor/openid');

		// Start the session
		Session::instance();

		// Load the OpenID lib
		require Kohana::find_file('vendor', 'openid/Auth/OpenID/Consumer');
		require Kohana::find_file('vendor', 'openid/Auth/OpenID/FileStore');
		require Kohana::find_file('vendor', 'openid/Auth/OpenID/SReg');
		require Kohana::find_file('vendor', 'openid/Auth/OpenID/PAPE');
	}
	
	public function action_index()
	{
		$this->request->redirect('');
	}

	public function action_signin()
	{
		$this->template->title = __('OpenID sign in');
		$this->template->content = View::factory('page/auth/openid/signin')
			->bind('errors', $errors)
			->bind('return_to', $return_to);

		// Get the return page URI, default to home
		$return_to = Arr::get($_REQUEST, 'return_to', '');

		// If openid_identity variable exists in the request, then add it to POST
		Arr::get($_REQUEST, 'openid_identity', FALSE) AND $_POST['openid_identity'] = Arr::get($_REQUEST, 'openid_identity');

		$data = Validate::factory($_POST)
			->filter('openid_identity', 'trim')
			->filter('openid_identity', 'strip_tags')
			->rule('openid_identity', 'not_empty')
			->rule('openid_identity', 'url');

		$data->check() AND $this->begin($data['openid_identity']);

		$_POST = $data->as_array();

		$errors = $data->errors('auth');
	}

	private function begin($openid='')
	{
		$store = new Auth_OpenID_FileStore($this->store_path);

		$consumer = new Auth_OpenID_Consumer($store);

		// Begin the OpenID authentication process.
		$auth_request = $consumer->begin($openid);

		if (!$auth_request)
		{
			throw new Exception(__('Authentication error: not a valid OpenID.'));
		}

		$sreg_request = Auth_OpenID_SRegRequest::build( array('email'), array('nickname', 'fullname') );

		if ($sreg_request)
		{
			$auth_request->addExtension($sreg_request);
		}

		$pape_request = new Auth_OpenID_PAPE_Request();

		$pape_request AND $auth_request->addExtension($pape_request);

		// Build the redirect URL with the return page included
		$redirect_url = URL::site('openid/finish?return_to=' . Arr::get($_REQUEST, 'return_to', ''), TRUE);

		// Redirect the user to the OpenID server for authentication.
		// Store the token for this authentication so we can verify the response.
		// For OpenID 1, send a redirect.  For OpenID 2, use a Javascript form to send a POST request to the server.
		if ($auth_request->shouldSendRedirect())
		{
			$redirect_url = $auth_request->redirectURL(URL::base(TRUE, TRUE), $redirect_url);

			if (Auth_OpenID::isFailure($redirect_url))
			{
				throw new Exception(__('Could not redirect to server:').' '.$redirect_url->message);
			}

			$this->request->redirect($redirect_url);
		} 
		else
		{
			// the OpenID library will return a full html document
			// Auth_OpenID::autoSubmitHTML will wrap the form in body and html tags
			// see: mobules/openid/vendor/Auth/OpenID/Consumer.php
			$form_html = $auth_request->htmlMarkup(
				URL::base(TRUE, TRUE),
				$redirect_url,
				false,
				array('id' => 'openid_message')
			);
			
			// we just want the form HTML, so strip out the form 
			$form_html = preg_replace('/^.*<html.*<form/im', '<form', $form_html);
			$form_html = preg_replace('/<\/body>.*/im', '', $form_html);

			if (Auth_OpenID::isFailure($form_html))
			{
				throw new Exception(__('Could not redirect to server:').' '.$form_html->message);
			}

			$this->template->content->form = $form_html;
		}
	}

	public function action_finish()
	{
		// Get the OpenID identity
		$openid = Arr::get($_REQUEST, 'openid_identity');

		// Get the return page URI, default to home
		$return_to = Arr::get($_REQUEST, 'return_to', '');

		$store = new Auth_OpenID_FileStore($this->store_path);

		$consumer = new Auth_OpenID_Consumer($store);

		$response = $consumer->complete(URL::site($this->request->uri, TRUE));

		if ($response->status == Auth_OpenID_CANCEL)
		{
			throw new Exception(__('OpenID authentication cancelled.'));

		}
		elseif ($response->status == Auth_OpenID_FAILURE)
		{
			throw new Exception(__('OpenID authentication failed:').' '.$response->message);
		} 
		elseif ($response->status == Auth_OpenID_SUCCESS)
		{
			$openid = htmlentities( $response->getDisplayIdentifier() );

			$user = ORM::factory('user')->save_openid($openid);

			Auth::instance()->force_login($user);
			
			$message = $user->username.' successfully signed in.';
			Message::set(Message::SUCCESS, __($message));
			
			$this->request->redirect($return_to);
		}
	}

} // End Controller_Auth_OpenID
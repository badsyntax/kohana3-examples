<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @User controller
 */
class Controller_Auth_User extends Controller_Base {

	public function action_index()
	{
		$this->request->redirect('');
	}
 
	public function action_signin()
	{
		// Redirect if user is logged in
		Auth::instance()->logged_in() AND $this->request->redirect('');

		// Set template vars
		$this->template->title = __('Sign in');
		$this->template->content = View::factory('page/auth/signin' . (Request::$is_mobile ? '_mobile' : ''))
			->bind('errors', $errors)
			->bind('return_to', $return_to)
			->bind('urls', $urls);
	
		// Get the return page URI, default to home
		$return_to = Arr::get($_REQUEST, 'return_to', '');

		// Build the signin URLs
		$urls = array(
			'twitter'	=> "/oauth/twitter/signin?return_to={$return_to}",
			'google'	=> "/openid/signin?openid_identity=https://www.google.com/accounts/o8/id&return_to={$return_to}",
			'yahoo'		=> "/openid/signin?openid_identity=https://me.yahoo.com&return_to={$return_to}",
			'openid'	=> "/openid/signin?return_to={$return_to}",
			'reset_pass'	=> "/user/reset_password?return_to={$return_to}"
		);

		if ($_POST)
		{
			// If successfull login then redirect
			if (ORM::factory('user')->login($_POST))
			{
				$message = $_POST['username'].' successfully signed in.';
				Message::set(Message::SUCCESS, __($message));
							
				$this->request->redirect($return_to);
			}
		
			$errors = $_POST->errors('signin');
		}
	}
	
	public function action_signup()
	{
		// Redirect if user is logged in
		Auth::instance()->logged_in() AND $this->request->redirect('');		

		// Set template vars
		$this->template->title = __('Sign up'); 
		$this->template->content = View::factory('page/auth/signup')
			->bind('errors', $errors);

		// If successful signup then redirect to login page
		if (ORM::factory('user')->signup($_POST)){
			
			$message = $_POST['username'].' successfully registerd.';
			Message::set(Message::SUCCESS, __($message));
			
			$this->request->redirect('');			
		}
		
		if ($errors = $_POST->errors('signup'))
		{
			 Message::set(Message::ERROR, __('Please correct the errors.'));
		}

		$_POST = $_POST->as_array();
	}

	public function action_profile()
	{
		// Redirect if user is logged in
		!Auth::instance()->logged_in() AND $this->request->redirect('user/signin');
		
		$this->template->title = __('Profile');
		$this->template->content = View::factory('page/auth/profile')
			->bind('errors', $errors);
			
		$user = Auth::instance()->get_user();

		// Update logged in user details, if successfull then redirect to profile page
		if ($user->update($_POST)){
			
			$message = $user->username.' profile updated.';
			Message::set(Message::SUCCESS, __($message));
				
			$this->request->redirect('user/profile');
		}
		
		if ($errors = $_POST->errors('profile'))
		{
			 Message::set(Message::ERROR, __('Please correct the errors.'));
		}
	}

	public function action_reset_password()
	{
		$this->template->title = __('Reset password');
		$this->template->content = View::factory('page/auth/reset_password')
			->bind('errors', $errors)
			->bind('message_sent', $message_sent);

		// Try send reset passwork link in email
		if ( ORM::factory('user')->reset_password($_POST))
		{
			// Store the result in session FIXME use messages class
			Session::instance()->set('message_sent', TRUE);

			// Redirect user to prevent refresh on POST request
			$this->request->redirect(URL::site($this->request->uri(array('action' => 'reset_password'))));
		}

		// Get and delete the message_sent status from session
		$message_sent = Session::instance()->get('message_sent', FALSE) AND Session::instance()->delete('message_sent');

		if ($errors = $_POST->errors('reset_password'))
		{
			 Message::set(Message::ERROR, __('Please correct the errors.'));
		}
	}

	public function action_confirm_reset_password()
	{
		$this->template->title = __('Reset password');
		$this->template->content = View::factory('page/auth/confirm_reset_password')
			->set('token', @$_REQUEST['auth_token'])
			->bind('errors', $errors);
		
		$id = (int) Arr::get($_REQUEST, 'id');

		$token = (string) Arr::get($_REQUEST, 'auth_token');

		ORM::factory('user', $id)->find()->confirm_reset_password($_POST, $token);

		if ($errors = $_POST->errors('confirm_reset_password'))
		{
			Message::set(Message::ERROR, __('Please correct the errors.'));
		}
	}

	public function action_signout()
	{
		Auth::instance()->logout();

		$this->request->redirect('');		
	}

	public function action_service()
	{
		$this->template->title = __('Auth service');

		$this->template->content = View::factory('page/auth/service_mobile');
	}

} // End Controller_Auth_Auth

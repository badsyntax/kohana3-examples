<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @auth controller - part of the Kohana3-examples package
 */

class Controller_Auth extends Controller_Base {

	public function action_index()
	{
		Request::instance()->redirect('');
	}
 
	public function action_signin()
	{
		Auth::instance()->logged_in() AND Request::instance()->redirect('');		

		$this->template->title = 'sign in';
		$this->template->content = View::factory('page/auth/signin');

		if ($_POST){
			
			ORM::factory('user')->login($_POST) AND Request::instance()->redirect('');

			$this->template->content->errors = $_POST->errors('signin');
		}
	}
	
	public function action_signup()
	{
		Auth::instance()->logged_in() AND Request::instance()->redirect('');		

		$this->template->title = 'sign up'; 
		$this->template->content = View::factory('page/auth/signup');		

		ORM::factory('user')->signup($_POST) AND Request::instance()->redirect('');			
	 
		$this->template->content->errors = $_POST->errors('signup');
	}

	public function action_profile()
	{
		!Auth::instance()->logged_in() AND Request::instance()->redirect('sign-in');
		
		$this->template->title = 'profile';
		$this->template->content = View::factory('page/auth/profile');
		$this->template->content->user = Auth::instance()->get_user();
	
		ORM::factory('user', $this->template->content->user->id)->update($_POST) AND Request::instance()->redirect('auth/profile');

		$this->template->content->errors = $_POST->errors('profile');
	}

	public function action_reset_password()
	{
		$this->template->title = 'Reset password';
		$this->template->content = new View('page/auth/reset_password');

		ORM::factory('user')->reset_password($_POST);

		$this->template->content->message_sent = Session::instance()->get('message_sent', FALSE) AND Session::instance()->delete('message_sent');

		$this->template->content->errors = $_POST->errors();
	}
	
	public function action_signout()
	{
		Auth::instance()->logout();

		Request::instance()->redirect('');		
	}
}

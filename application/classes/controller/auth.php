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
			
		if ($_POST) {

			ORM::factory('user')->login($_POST) AND Request::instance()->redirect('');

			$this->template->content->errors = $_POST->errors('signin');
		}
	}
	
	public function action_signup()
	{
		Auth::instance()->logged_in() AND Request::instance()->redirect('');		

		$this->template->title = 'sign up'; 

		$this->template->content = View::factory('page/auth/signup');		

		if ($_POST){

			$user = ORM::factory('user');	
	 
			$data = $user->validate_create($_POST);			
	 
			if ($data->check()) {

				$user->values($data);
				$user->save();
				$user->add('roles', new Model_Role(array('name' =>'login')));
	 
				Auth::instance()->login($data['username'], $data['password']);
	 
				Request::instance()->redirect('');
			} 

			$this->template->content->errors = $data->errors('signup');
		}
	}

	public function action_profile()
	{
		!Auth::instance()->logged_in() AND Request::instance()->redirect('sign-in');
		
		$this->template->title = 'profile';
		$this->template->content = View::factory('page/auth/profile');
		$this->template->content->user = Auth::instance()->get_user();

		if ($_POST) {

			$user = ORM::factory('user', $this->template->content->user->id);

			$post = $user->validate_update($_POST);

			if ($post->check()) {

				$user->values($post);
				$user->save();
			} else {

				$this->template->content->errors = $post->errors('profile');
			}
		}
	}

	// reset password by cresting token ,sending link in email and resaving password
	public function action_forgot()
	{
		$this->template->title = 'Reset password';
		$this->template->content = new View('page/auth/forgot');

		$data = Validate::factory($_POST)
			->filter('email', 'trim')
			->rule('email', 'not_empty')
			->rule('email', 'email');

		if ($data->check()){

			$user = ORM::factory('user')->where('email', '=', $_POST['email'])->find();

			$message_text = "Hi {$user->username}.\n\nYou requested your password to be reset at: ".URL::site(NULL, TRUE);
			$message_text .= "\n\nFollow this link to reset your password: ".URL::site('auth/reset', TRUE);

			$transport = Swift_MailTransport::newInstance();

			$mailer = Swift_Mailer::newInstance($transport);

			$message = Swift_Message::newInstance("Password reset")
				->setFrom(array(
					'your_website@domain'
				))
				->setTo(array(
					$user->email => $user->username
				))
				->addPart($message_text, 'text/plain');

			if ($mailer->send($message)) {

				Session::instance()->set('message_sent', TRUE);

				Request::instance()->redirect(Request::instance()->uri);
			}

		} else {

			$_POST = $data->as_array();
	
			$this->template->content->message_sent = Session::instance()->get('message_sent', FALSE) AND Session::instance()->delete('message_sent');

			$this->template->content->errors = $data->errors();
		}
	}
	
	public function action_signout()
	{
		Auth::instance()->logout();

		Request::instance()->redirect('');		
	}
}

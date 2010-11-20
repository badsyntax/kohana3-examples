<?php
class Model_User extends Model_Auth_User {

	public function signup(array & $data)
	{
		$data = Validate::factory($data)
			->rules('password', $this->_rules['password'])
			->rules('username', $this->_rules['username'])
			->rules('email', $this->_rules['email'])
			->rules('password_confirm', $this->_rules['password_confirm'])
			->filter('username', 'trim')
			->filter('email', 'trim')
			->filter('password', 'trim')
			->filter('password_confirm', 'trim');
 
		foreach($this->_callbacks['username'] as $callback){
			$data->callback('username', array($this, $callback));
		}
 
		foreach($this->_callbacks['email'] as $callback){
			$data->callback('email', array($this, $callback));
		}		
 
		if ( !$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		$this->add('roles', new Model_Role(array('name' =>'login')));

		Auth::instance()->login($data['username'], $data['password']);

		return TRUE;
	}

	public function update(array & $data)
	{
		$data = Validate::factory($data)
			->rules('email', $this->_rules['email'])
			->rules('password', $this->_rules['password'])
			->rules('password_confirm', $this->_rules['password_confirm'])
			->filter('email', 'trim')
			->filter('password', 'trim')
			->filter('password_confirm', 'trim');

		if ( !$data->check()) return FALSE;

		$this->values($data);
		$this->save();

		return TRUE;
	}

	public function reset_password(array & $data)
	{
		$data = Validate::factory($_POST)
			->filter('email', 'trim')
			->rule('email', 'not_empty')
			->rule('email', 'email');

		if ( !$data->check()) return FALSE;

		$this->where('email', '=', $_POST['email'])->find();

		$message_text = "Hi {$this->username}.\n\nYou requested your password to be reset at: ".URL::site(NULL, TRUE);

		$message_text .= "\n\nFollow this link to reset your password: ".URL::site('auth/reset', TRUE);

		$transport = Swift_MailTransport::newInstance();

		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance("Password reset")
			->setFrom(array(
				'your_website@domain'
			))
			->setTo(array(
				$this->email => $this->username
			))
			->addPart($message_text, 'text/plain');

		if ($mailer->send($message)) {

			Session::instance()->set('message_sent', TRUE);

			Request::instance()->redirect(Request::instance()->uri);
		}

		return TRUE;
	}
}

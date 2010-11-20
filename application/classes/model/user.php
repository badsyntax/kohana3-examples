<?php
/*
 * some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
 */

class Model_User extends Model_Auth_User {

	public function signup(& $data)
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
 
		if (!$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		$this->add('roles', new Model_Role(array('name' =>'login')));

		Auth::instance()->login($data['username'], $data['password']);

		return TRUE;
	}

	public function update(& $data)
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

	public function reset_password(& $data)
	{
		$data = Validate::factory($data)
			->filter('email', 'trim')
			->rule('email', 'not_empty')
			->rule('email', 'email');

		if ( !$data->check()) return FALSE;

		$this->where('email', '=', $data['email']);
		$this->find();

		if (!$this->loaded()) return FALSE;

		$request_vars = array(
			'id='.$this->id,
			'token='.Auth::instance()->hash_password($this->email.'+'.$this->password.'+'.$time),
			'time='.time()
		);

		$url = URL::site(Route::get('auth')->uri(array('action' => 'confirm_reset_password')).'?'.implode('&', $request_vars), TRUE);

		$email_body = View::factory('email/auth/reset_password')
			->set('user', $this)
			->set('url', $url);

		$message = Swift_Message::newInstance("Password reset")
			->setFrom(array('your_website@domain'))
			->setTo(array($this->email => $this->username))
			->addPart($email_body, 'text/plain');

		$transport = Swift_MailTransport::newInstance();

		if (Swift_Mailer::newInstance($transport)->send($message)) {

			Session::instance()->set('message_sent', TRUE);

			Request::instance()->redirect(Request::instance()->uri);
		}

		return TRUE;
	}

	public function confirm_reset_password(& $data, $token, $time)
	{
		//if (empty($id) OR empty($token) OR empty($time)) return FALSE;

		$data = Validate::factory($data)
			->filter('password', 'trim')
			->filter('password_confirm', 'trim')
			->rules('password', $this->_rules['password'])
			->rules('password_confirm', $this->_rules['password_confirm']);

		if ( !$data->check()) return FALSE;
		
		if (!$this->loaded()) die('no user');

		//if ($token !== Auth::instance()->hash_password($this->email.'+'.$this->password.'+'.$time, Auth::instance()->find_salt($token))) return FALSE;

		$this->password = $data['password'];
		$this->save();

		Request::instance()->redirect('auth/signin');
	}
}

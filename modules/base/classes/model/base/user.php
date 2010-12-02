<?php
/*
* User model
* some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
*/

class Model_Base_User extends Model_Auth_User {

	public function login(array & $array, $redirect = FALSE)
	{

		if (!isset($array['username'])) $array['username'] = '';

		return parent::login($array, $redirect);
	}


	public function signup(& $data)
	{
		$data = Validate::factory($data)
			->rules('password', $this->_rules['password'])
			->rules('username', $this->_rules['username'])
			->rules('email', $this->_rules['email'])
			->rules('password_confirm', $this->_rules['password_confirm']);
 
		foreach($this->_callbacks['username'] as $callback)
		{
			$data->callback('username', array($this, $callback));
		}
 
		foreach($this->_callbacks['email'] as $callback)
		{
			$data->callback('email', array($this, $callback));
		}		
 
		if (!$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		$this->add('roles', new Model_Role(array('name' =>'login')));

		Message::set(Message::SUCCESS, __('User successfully registered!'));

		Auth::instance()->login($data['username'], $data['password']);

		return $data;
	}

	public function update(& $data)
	{
		$data = Validate::factory($data)
			->rules('email', $this->_rules['email'])
			->rules('password', $this->_rules['password'])
			->rules('password_confirm', $this->_rules['password_confirm']);
		
		foreach($this->_callbacks['email'] as $callback)
		{
			$data->callback('email', array($this, $callback));
		}		

		if ( !$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		
		Message::set(Message::SUCCESS, __('User successfully updated!'));

		return $data;
	}

	public function update_roles(& $roles)
	{
		foreach(ORM::factory('role')->find_all() as $role) {

			if (in_array($role->id, $roles)) {

				try {
					// Add roles relationship
					$this->add('roles', new Model_Role(array('id' => $role->id)));

				} catch(Exception $e){}

			} else {
				// Remove roles relationship
				$this->remove('roles', new Model_Role(array('id' => $role->id)));
			}
		}
	}

	public function reset_password(& $data)
	{
		$data = Validate::factory($data)
			->filter('email', 'trim')
			->rules('email', $this->_rules['email']);

		if ( !$data->check()) return FALSE;

		$this->where('email', '=', $data['email']);
		$this->find();

		if (!$this->loaded()) return FALSE;

		// generate the token
		$token = Auth::instance()->hash_password($this->email.'+'.$this->password);
	
		// generate the reset password link
		$uri = Request::instance()->uri(array('action' => 'confirm_reset_password')) . '?id=' . $this->id . '&auth_token=' . $token;
		$url = URL::site($uri, TRUE);

		// set the token in cookie
		Cookie::set('token', $token);

		$body = View::factory('email/auth/reset_password')
			->set('user', $this)
			->set('url', $url);

		$message = Swift_Message::newInstance()
			->setSubject('Password reset')
			->setFrom(array('your_website@domain'))
			->setTo(array($this->email => $this->username))
			->addPart($body, 'text/plain');

		$transport = Swift_MailTransport::newInstance();

		Swift_Mailer::newInstance($transport)->send($message);

		return TRUE;
	}

	public function confirm_reset_password(& $data, $token)
	{
		$cookie_token = Cookie::get('token', FALSE);

		if ( $token !== $cookie_token ) 
		{
			throw new Exception(__('Invalid auth token.'));
		}

		$data = Validate::factory($data)
			->filter('token', 'trim')
			->rules('password', $this->_rules['password'])
			->rules('password_confirm', $this->_rules['password_confirm']);

		$hash = $this->email.'+'.$this->password;
		$salt = Auth::instance()->find_salt($token);

		if ( !$data->check() OR !$this->loaded() OR $token !== Auth::instance()->hash_password($hash, $salt)) {

			return FALSE;
		}
		
		/* Remove token from cookie */
		Cookie::delete('token');

		/* Change users password. The password will be auto-hashed on save.*/
		$this->password = $data['password'];
		$this->save();

		Request::instance()->redirect('auth/signin?username='.$this->username);
	}

	public function save_openid($openid='')
	{
		$this->where('openid_id', '=', $openid)->find();

		if ( $this->loaded()) return $this;

		$this->openid_id = 
		$this->email = 
		$this->username = $openid;
		
		return $this->save();
	}
	
} // End Model_User

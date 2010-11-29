<?php

class Model_User extends Model_Base_User {

	public function add_admin(& $data)
	{
		$roles = isset($data['roles']) ? (array) $data['roles'] : array();

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

		foreach($roles as $role)
		{
			$this->add('roles', new Model_Role(array('id' => $role)));
		}
		
		Message::set(Message::SUCCESS, __('User successfully saved!'));

		return $data;
	}

	public function update_admin(& $data)
	{
		$roles = isset($data['roles']) ? (array) $data['roles'] : array();

		$data = Validate::factory($data)
			->rules('email', $this->_rules['email'])
			->rules('username', $this->_rules['username']);

		!empty($data['password']) AND $data
			->rules('password', $this->_rules['password'])
			->rules('password_confirm', $this->_rules['password_confirm']);
		
		foreach($this->_callbacks['email'] as $callback)
		{
			$data->callback('email', array($this, $callback));
		}		

		if ( !$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		$this->update_roles($roles);
		
		Message::set(Message::SUCCESS, __('User successfully updated!'));
		
		return $data;
	}
	
} // End Model_User

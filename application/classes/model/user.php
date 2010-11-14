<?php
class Model_User extends Model_Auth_User {
 
	public function validate_create(& $array) {

		$array = Validate::factory($array)
				->rules('password', $this->_rules['password'])
				->rules('username', $this->_rules['username'])
				->rules('email', $this->_rules['email'])
				->rules('password_confirm', $this->_rules['password_confirm'])
				->filter('username', 'trim')
				->filter('email', 'trim')
				->filter('password', 'trim')
				->filter('password_confirm', 'trim');
 
		foreach($this->_callbacks['username'] as $callback){
			$array->callback('username', array($this, $callback));
		}
 
		foreach($this->_callbacks['email'] as $callback){
			$array->callback('email', array($this, $callback));
		}		
 
		return $array;
	}

	public function validate_update(& $array){
		
		$array = Validate::factory($array)
				->rules('password', $this->_rules['password'])
				->rules('password_confirm', $this->_rules['password_confirm'])
				->filter('email', 'trim')
				->filter('password', 'trim')
				->filter('password_confirm', 'trim');
		
		return $array;
	}
}

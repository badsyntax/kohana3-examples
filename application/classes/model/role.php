<?php
/*
 * Role model
 * some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
 */

class Model_Role extends Model_Auth_Role {

	public function create(& $data)
	{
		$data = Validate::factory($data)
			->rules('name', $this->_rules['name'])
			->rules('description', $this->_rules['description']);

		if (!$data->check()) return FALSE;
 
		$this->values($data);
		$this->save();

		return $data;
	}

	public function update(& $data)
	{
		$data = Validate::factory($data)
			->rules('name', $this->_rules['name'])
			->rules('description', $this->_rules['description']);

		if (!$data->check()) return FALSE;
 
		$this->values($data);
		$this->save();

		return $data;
	}

} // End Model_Role

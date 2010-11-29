<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {

	
	/*
	Add id attribute to fields
	*/

	/*
	public static function input($name, $value = NULL, array $attributes = NULL)
	{
		if( ! isset($attributes['id']))
			$attributes['id'] = $name;
		return parent::input($name, $value, $attributes);
	}

	public static function select($name, array $options = NULL, $selected = NULL, array $attributes = NULL) 
	{
		if( ! isset($attributes['id']))
			$attributes['id'] = $name;
		return parent::select($name, $options, $selected, $attributes);
	}
	*/
}

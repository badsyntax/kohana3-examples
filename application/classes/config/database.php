<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database configuration reader.
 */
class Config_Database extends Kohana_Config_Reader {

	// Configuration group name
	protected $_configuration_group;

	// If we are relying on modules being active then 
	protected $_allowed_groups = array('site');

	protected $_cache_lifetime = NULL;

	protected $_tablename = 'config';

	public function __construct()
	{
		// Load the empty array
		parent::__construct();

		if ($this->_cache_lifetime === NULL)
		{
			$this->_cache_lifetime = PHP_INT_MAX;
		}
	}

	private function save_cache($cache = NULL)
	{
		if ($cache) return $cache;

		$cache = array();

		$db_config = ORM::factory($this->_tablename)->find_all();

		foreach($db_config as $item) {
			
			!isset($cache[$item->group]) AND $cache[$item->group] = array();
			
			$cache[$item->group][$item->name] = $item->value;
		}

		Cache::instance()->set($cache_key, $cache, $this->_cache_lifetime);

		return $cache;
	}

	public function load($group, array $config = NULL)
	{
		if (in_array($group, $this->_allowed_groups))
		{
			$cache_key = sha1('database_config');

			$cache = $this->save_cache( Cache::instance()->get($cache_key) );
	
			isset($cache[$group]) AND $config = array($group => $cache[$group]);
		}
		
		return parent::load($group, $config);
	}

} // End Config_Database

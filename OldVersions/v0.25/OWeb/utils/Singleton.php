<?php


namespace OWeb\utils;

abstract class Singleton
{
	protected static $instances = array();

	static function getInstance()
	{
		$class = get_called_class();
		if(!isset(self::$instances[$class]))
		{
			self::$instances[$class] = new $class();
		}
		return self::$instances[$class];
	}

	/**
	 * Force a singleton object to be instanciated with the given instance
	 * Use with care!
	 */
	static function forceInstance(Singleton $object, $class = null)
	{
		if($class == null)
			$class = get_class($object);
		
		if(!isset(self::$instances[$class]))
		{
			self::$instances[$class] = $object;
		}
		else
		{
			throw new \Exception(sprintf('Object of class %s was previously instanciated', $class));
		}
	}

	protected function __construct() {}

	final protected function __clone() {}
}


?>
<?php

namespace OWeb\types;


/**
 * Description of NamedClass
 *
 * @author De Cramer Oliver
 */
abstract class NamedClass {
	
	private static $_exploded_name;
	
	private static $_full_path;
	
	private static $_relative_path;
	
	private static $_start_path;
	
	public function get_exploded_name() {
		return self::$_exploded_name[get_class($this)];
	}
	
	public function get_exploded_num($i) {
		return self::$_exploded_name[get_class($this)][$i];
	}

	public function get_full_path() {
		return self::$_full_path[get_class($this)];
	}

	public function get_relative_path() {
		return self::$_relative_path[get_class($this)];
	}

	public function get_start_path() {
		return self::$_start_path[get_class($this)];
	}
	
	public static function get_exploded_nameOf($class) {
		return self::$_exploded_name[$class];
	}
	
	public static function get_exploded_numOf($class, $i) {
		return self::$_exploded_name[$class][$i];
	}

	public static function get_full_pathOf($class) {
		return self::$_full_path[$class];
	}

	public static function get_relative_pathOf($class) {
		return self::$_relative_path[$class];
	}

	public static function get_start_pathOf($class) {
		return self::$_start_path[$class];
	}

	public static function newNamedClass($name, $ename, $fpath, $rpath, $path){
		self::$_exploded_name[$name]=$ename;
		self::$_full_path[$name]=$fpath;
		self::$_relative_path[$name]=$rpath;
		self::$_start_path[$name]=$path;				
	}
}

?>

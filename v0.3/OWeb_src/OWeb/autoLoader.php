<?php

namespace OWeb;

require_once OWEB_DIR_MAIN.'/utils/Singleton.php';

require_once OWEB_DIR_MAIN.'/Exception.php';

/**
 * Description of autoLoader
 *
 * @author De Cramer Oliver
 */
class autoLoader extends \OWeb\utils\Singleton{
	
	private $nameSpaces = array();
	
	public function __construct() {
        spl_autoload_register(array($this, 'autoload'));

		//Add default nameSpaces to autoLoad
		$this->nameSpaces['OWeb'] = array(OWEB_DIR_MAIN);

		$this->nameSpaces['Controller'] = array(OWEB_DIR_MAIN.'/defaults/controllers', OWEB_DIR_CONTROLLERS);
		$this->nameSpaces['View'] = array(OWEB_DIR_MAIN.'/defaults/views',OWEB_DIR_VIEWS);
		$this->nameSpaces['Model'] = array(OWEB_DIR_MAIN.'/defaults/models',OWEB_DIR_MODELS);
		$this->nameSpaces['Extension'] = array(OWEB_DIR_MAIN.'/defaults/extensions',OWEB_DIR_EXTENSIONS);
		$this->nameSpaces['Page'] = array(OWEB_DIR_MAIN.'/defaults/page',OWEB_DIR_PAGES);
    }
	
	public function autoload($class){
		try{
			$this->load($class, explode('\\', $class));
		}catch(\Exception $ex){
			throw new \OWeb\Exception("The class '$class' couldn't be loaded",0,$ex);
		}
	}
	
	public function load($class, $expClass){
		
		//Checking Class Prefix.
		if(!isset($this->nameSpaces[$expClass[0]]))
			throw new \OWeb\Exception("Unknow namespace : '".$expClass[0]."'");
		
		
		$path = $this->getPath($expClass);
		
		require_once $path[0];
		
		if(method_exists($class, "newNamedClass"))
			$class::newNamedClass ($class, $expClass, $path[0], $path[2], $path[1]);

	}
	
	public function loadByPath($path){
		require_once $path;
	}
	
	public function getPath($expClass){
		//Creating main path
		$file = '';
		$i=1;
		while($i < \sizeof($expClass)){
			$file .= '/'.$expClass[$i];
			$i++;
		}
		$file .= '.php';
		$filesL = "";
		//Checking for each path.
		for($i= sizeof($this->nameSpaces[$expClass[0]])-1; $i>=0; $i--){
			$filesL .= $this->nameSpaces[$expClass[0]][$i].$file." || ";
			if(\file_exists($this->nameSpaces[$expClass[0]][$i].$file))
				return array($this->nameSpaces[$expClass[0]][$i].$file,
								$this->nameSpaces[$expClass[0]][$i],
								$file);
		}
		
		throw new \OWeb\Exception("The file '$file' couldn't be found. At : ".$filesL);
	}
	
}

?>

<?php

namespace OWeb\manage;

/**
 * Manages the header files included to your web page. 
 * This will not check for double includes it will just store the data
 * until you are ready to start the drawing of your page.  
 * 
 * If THe header you add is a js or css and aren't external links it will automatically correct 
 * the path to were ares stored the .js and css files.
 * 
 * ! The existance of the files won't be checked
 *
 * @author De Cramer Oliver
 */
class Headers extends \OWeb\utils\Singleton{
	
	/*
	 * The file you want to include is a a javasripty file, a .js. 
	 */
	const javascript = 0;
	/*
	 * A Css
	 */
    const css = 1;
	/**
	 * You just want to add a bit of Code inside the header. This code want't be modified. 
	 */
    const code = 2;
	
	//List of the headers
	private $headers = array();
	
	/**
	 * Allows you to add a header to the we bpage
	 * 
	 * @param type $code The url to the css, js or the name of the css or js file. 
	 *						The path will be added automatically.
	 * @param type $type The type of the Header you want to add.
	 */
	public function addHeader($code, $type){
		switch ($type){
			case self::javascript : 
				$code =$this->getPath(OWEB_HTML_DIR_JS, $code);
				break;
			case self::css : 
				$code =$this->getPath(OWEB_HTML_DIR_CSS, $code);
			
		}
		$this->headers[] = new \OWeb\types\Header($code, $type);
	}
	
	
	private function getPath($path1, $path2){
		if($path2[0]=='h'&&$path2[1]=='t'&&$path2[2]=='t'&&$path2[3]=='p')
			return $path2;
		else
			return $path1.'/'.$path2;
	}
	
	/**
	 * Display the Headers that has been added.
	 */
	public function display(){
		foreach ($this->headers as $h){
			echo $h->getCode();
		}
	}
	
	/**
	 * Returns the string that the display function would display.
	 * 
	 * @return type The headers that has been added as a String. 
	 */
	public function toString(){
		$s = "";
		foreach ($this->headers as $h){
			echo $s.=$h->getCode();
		}
		return $s;
	}
	
}

?>

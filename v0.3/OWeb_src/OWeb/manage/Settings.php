<?php

namespace OWeb\manage;
/**
 * Will load setting file(s)
 * OWeb core will ask it to load the main setting file. 
 * 
 * The settings manager seperates settings of different 
 * Classes so that you can easily have acces to a setting
 * It can load multiple different files, for different Classes
 * 
 * @author oliver
 */
class Settings extends \OWeb\utils\Singleton{


    private $settings;

	/**
	 * The Setting array for you, in the default file or the file you asked it to check
	 * 
	 * @param type $asker The namen or Object of the one who asks for the settings
	 * @param string $file THe file in which it hopes to get the settings. By default the default file
	 * @return array()
	 */
    public function getSetting($asker="", $file=""){
		 
		 if(empty($file))
			 $file = OWEB_CONFIG;

		$this->loadFile($file);

        if(!\is_string($asker))
            $asker = \get_class($asker);
		
        if(isset($this->settings[$file][$asker])){
            return $this->settings[$file][$asker];
        }else
            return false;
    }
	
	public function getDefSettingValue($asker, $asked){
		$settings = $this->getSetting($asker);
		return isset($settings[$asked]) ? $settings[$asked] : false;
	}


    private function loadFile($file=OWEB_DIR_CONFIG){

        if(!isset($this->settings[$file])){
			try{
				$f = parse_ini_file($file, true);
			}catch(\Exception $ex){
				throw new \OWeb\manage\exceptions\Settings("Failed to load Settings file : '$file'", 0, $ex);
			}
			$this->settings[$file] = $f;
        }
    }


}
?>

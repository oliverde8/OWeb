<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */
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
	 * @param String $asker The namen or Object of the one who asks for the settings
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

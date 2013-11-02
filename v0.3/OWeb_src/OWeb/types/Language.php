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
namespace OWeb\types;

use OWeb\types\Controller;

/**
 * Description of Language
 *
 * @author De Cramer Oliver
 */
class Language {

	private $c_lang;
	private $lang = array();
	public static $default_language;


    public function init(\OWeb\types\Controller $controller) {
        $this->tinit(get_class($controller));
    }

	public function tinit($name) {
		//echo $name.'*';
		$settings = \OWeb\manage\Settings::getInstance()->getSetting($this);

		self::$default_language = $settings['default_language'];

		try {

			$cname = Controller::get_exploded_nameOf($name);
			$path = '/' . $cname[0];
			$path .= str_replace(".php", "", Controller::get_relative_pathOf($name));

			$ext = \OWeb\manage\Extensions::getInstance()->tryGetExtension('user\connection\TypeConnection');
			if ($ext != null && $ext->getlang() != self::$default_language) {
				$this->c_lang = $ext->getlang();

				$this->loadFile(OWEB_DEFAULT_LANG_DIR . '/' . $path . '/' . $this->c_lang . '.php', $this->c_lang);
				$this->loadFile(OWEB_DEFAULT_LANG_DIR . '/' . $this->c_lang . '.php', $this->c_lang);
			}
			else
				$this->c_lang = self::$default_language;

			$this->loadFile(OWEB_DEFAULT_LANG_DIR . $path . '/' . self::$default_language . '.php', self::$default_language);
			$this->loadFile(OWEB_DEFAULT_LANG_DIR . '/' . self::$default_language . '.php', self::$default_language);

			$pclass = get_parent_class($name);
            if($pclass !=  'OWeb\types\Controller' && $pclass !="")
                $this->tinit($pclass);
		} catch (\Exception $ex) {

		}
	}

	public function initNo() {
		$settings = \OWeb\manage\Settings::getInstance()->getSetting($this);

		self::$default_language = $settings['default_language'];

		try {
			
			$ext = \OWeb\manage\Extensions::getInstance()->tryGetExtension('user\connection\TypeConnection');
			if ($ext != null && $ext->getlang() != self::$default_language) {
				$this->c_lang = $ext->getlang();
				
				$this->loadFile(OWEB_DEFAULT_LANG_DIR . '/' . $this->c_lang . '.php', $this->c_lang);
			}else
				$this->c_lang = self::$default_language;
			

			$this->loadFile(OWEB_DEFAULT_LANG_DIR . '/' . self::$default_language . '.php', self::$default_language);
			
		} catch (\Exception $ex) {
			throw \OWeb\Exception("Language File can't ve loaded", 0, $ex);
		}
	}

	private function loadFile($path, $lang) {
        //echo $path.'*';
		if (file_exists($path)) {
			include $path;
			$this->lang[] = $_L;
		}
	}

	public function get($name) {

		foreach ($this->lang as $lang) {
			if (isset($lang[$name]))
				return $lang[$name];
		}
		return "Unknown Text";
	}

	public function getLang() {
		return $this->c_lang;
	}

}

?>

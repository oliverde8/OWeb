<?php

namespace OWeb\types;

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

		$settings = \OWeb\manage\Settings::getInstance()->getSetting($this);

		self::$default_language = $settings['default_language'];

		try {

			$cname = $controller->get_exploded_name();
			$path = '/' . $cname[0];
			$path .= str_replace(".php", "", $controller->get_relative_path());

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
		} catch (\Exception $ex) {
			throw \OWeb\Exception("Language File can't ve loaded", 0, $ex);
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

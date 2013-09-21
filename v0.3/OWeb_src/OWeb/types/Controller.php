<?php

namespace OWeb\types;

/**
 * Description of Controller
 *
 * @author De Cramer Oliver
 */
abstract class Controller extends NamedClass {

	const ACTION_GET = 1;
	const ACTION_POST = 2;
	const ACTION_DOUBLE = 3;
	const ACTION_CUSTOM = 4;

	protected $action_mode;
	private $params = array();
	private $actions = array();
	private $language;
	protected $view = null;

	abstract public function init();

	abstract public function onDisplay();

	function __construct() {
		$this->action_mode = self::ACTION_GET;
		$this->language = new \OWeb\types\Language();
	}

	protected function addAction($action, $nom_func) {
		$this->actions[$action] = $nom_func;
	}

	protected function resetActionsAll() {
		$this->actions = array();
	}

	protected function resetAction($actioName) {
		if (isset($this->actions[$actioName]))
			unset($this->actions[$actioName]);
	}

	public function doAction($actionName) {
		call_user_func_array(array($this, $this->actions[$actionName]), array());
	}

	protected function registerEvent($eventName, $funcName) {
		\OWeb\manage\events::getInstance()->registerEvent($eventName, $this, $funcName);
	}

	public function loadParams() {
		switch ($this->action_mode) {
			case self::ACTION_DOUBLE :
				$a = array_merge(\OWeb\OWeb::getInstance()->get_post(), \OWeb\OWeb::getInstance()->get_get());
				break;
			case self::ACTION_GET :
				$a = \OWeb\OWeb::getInstance()->get_get();
				break;
			case self::ACTION_GET :
				$a = \OWeb\OWeb::getInstance()->get_post();
				break;
		}
		$this->params = $a;
	}

	public function addParams($paramName, $value) {
		$this->params[$paramName] = $value;
		return $this;
	}

	public function getParam($paramName) {
		if (isset($this->params[$paramName]))
			return $this->params[$paramName];
		else
			return null;
	}

	/**
	 * This will activate the usage of the language file
	 */
	protected function InitLanguageFile() {
		$this->language->init($this);
	}

	protected function getLangString($name) {
		return $this->language->get($name);
	}

	protected function l($name) {
		return $this->language->get($name);
	}

	protected function getLang() {
		return $this->language->getLang();
	}

    protected function disableProtectParams(){
        $this->auto_protectParams = false;
    }

    protected function enableProtectedParams(){
        $this->auto_protectParams = true;
    }

	public function display($ctr = null) {
		if ($ctr == null)
			$ctr = get_class($this);

		$path = self::get_relative_pathOf($ctr);

		$path1 = OWEB_DIR_VIEWS . '/' . $this->get_exploded_numOf($ctr, 0);
		$path2 = OWEB_DIR_MAIN . '/defaults/views' . '/' . $this->get_exploded_numOf($ctr, 0);

		if (file_exists($path1 . $path)) {
			$path = $path1 . $path;
		} else if (file_exists($path2 . $path)) {
			$path = $path2 . $path;
		} else {
			if ($ctr != '\OWeb\types\Controller') {
				$this->display(get_parent_class($ctr));
				return;
			} else {
				throw new \OWeb\manage\exceptions\Controller('Couldn\'t Find View of controller in : \'' . $path1 . $path . '\' , \'' . $path2 . $path . '\'.');
			}
		}
		//First we create the Default view
		$this->view = new \OWeb\types\View(get_class($this), $path, $this->language);

		//Second we ask our controller to prepare anything needed to be show in the page
		$this->onDisplay();

		//Maintenant on fait l'affichage
		$this->view->display();
	}



}

?>

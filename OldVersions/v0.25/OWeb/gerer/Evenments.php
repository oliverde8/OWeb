<?php

namespace OWeb\Gerer;

/**
 *
 * @author De Cramer Oliver
 */
class Evenments {


	private static $instance;
    private static $actions;
	
	public static function Init() {
		if (self::$instance == NULL)
			self::$instance = new self();
		return self::$instance;
	}

	public static function getInstance() {
		return self::$instance;
	}

    function addEvenment($nomEvenment, $objet, $fonction){

        $evenment["objet"] = $objet;
        $evenment["fonction"] = $fonction;

        self::$actions[$nomEvenment][]=$evenment;
    }

    function envoyerEvenment($nomEvenment, $param=array()){

        if(!isset(self::$actions[$nomEvenment]))
            return;

        $params = array();
        if(!is_array($param))$params[]=$param;
        else $params = $param;

        foreach (self::$actions[$nomEvenment] as $action) {
             call_user_func_array(array($action["objet"],$action["fonction"]),$params);
        }
    }


}
?>

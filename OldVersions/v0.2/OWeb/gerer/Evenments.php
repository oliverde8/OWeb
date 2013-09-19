<?php

namespace OWeb\Gerer;

/**
 *
 * @author oliver
 */
class Evenments {

    static $actions;

    static function addEvenment($nomEvenment, $objet, $foncion){

        $evenment["objet"] = $objet;
        $evenment["fonction"] = $foncion;

        self::$actions[$nomEvenment][]=$evenment;
    }

    static function envoyerEvenment($nomEvenment, $param=array()){

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

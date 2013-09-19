<?php

namespace OWeb\Type;

/**
 *
 * @author oliver
 */
abstract class Modele {


    static protected $gereur_extensions;

    static public function setgereur_extensions($extensions){
        self::$gereur_extensions = $extensions;
    }

}

?>

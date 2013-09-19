<?php

namespace Modele\library\livre;

use OWeb\Type\Modele;

use Modele\library\livre\db\dbLivre;



/**
 * 
 *
 * @author oliver
 */
class livres extends Modele{

    static $livres = array();
    static $connection;

    static function setConnection(\PDO $connection){
        self::$connection = $connection;
    }

    static function getLivre($idLivre){

        if(!isset(self::$livres[$idLivre]))
            self::$livres[$idLivre] = new dbLivre(self::$connection, $idLivre);

        return self::$livres[$idLivre];

    }
}
?>

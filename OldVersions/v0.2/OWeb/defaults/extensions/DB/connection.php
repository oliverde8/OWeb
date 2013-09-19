<?php

namespace Extension\DB;

use OWeb\Type\Extension;

/**
 * Cette class permet de ce connecter a une BD
 *  - Element de Configuration -
 *      [Extension_DB_connection]
 *           connection.type = mysql
 *           connection.host = localhost
 *           connection.dbname = oliverde8
 *           authontification.user = root
 *           authontification.password =
 * 
 * @author Oliver de Cramer
 */
class connection extends Extension{


    private $connection;
    private $etabli = false;
    
    private $reglages;

    protected function init(){
        $this->reglages = $this->chargerReglages();
    }

    protected function startConnection(){

       $con =  $this->reglages['connection.type'].':host='.$this->reglages['connection.host'].';dbname='.$this->reglages['connection.dbname'];

       $this->connection = new \PDO($con, $this->reglages['authontification.user'], $this->reglages['authontification.password']);

       $this->etabli = true;
    }



    public function get_Connection(){
        if(!$this->etabli)
            $this->startConnection ();
        return $this->connection;
    }
}
?>

<?php

namespace Modele\library\livre\db;

use OWeb\Type\Modele;

use Modele\library\livre\auteurs;

class dbAuteurSecondaire extends Modele implements \Iterator{

    private $c;

    private $auteurs;
    private $position;


    function __construct(\PDO $connection, $idLivre = null){

         $this->c = $connection;

         $query = $this->c->query("SELECT * FROM library_Auteur_Secondaire WHERE id_Livre=".$idLivre);
        
         if($query!=null){

            auteurs::setConnection($this->c);

            while($result = $query->fetch(\PDO::FETCH_ASSOC)){
                $auteurs[] = auteurs::getAuteur($result["id_Auter"]);
            }
         }
    }

    public function getAuteurs() {
        return $this->auteurs;
    }

    public function addAuteur(dbAuteur $auteurs) {
        $this->auteurs[] = $auteurs;
    }




    // implements Iterator:
    public function current(){
        return $this->auteurs[$this->position];
    }

    public function key(){
        return $this->position;
    }

    public function next(){
        $this->position++;
        return $this->_elems[$this->position];
    }

    public function rewind(){
        $this->position = 0;
    }

    public function valid(){
        return array_key_exists($this->position, $this->auteurs);
    }


}
?>

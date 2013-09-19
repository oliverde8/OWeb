<?php


namespace Modele\library\db;

use OWeb\Type\Modele;

/**
 * @author oliver
 */
class dbCategorie extends Modele{

    private $c;

    private $idCategory;
    private $nom;
    private $description;


    function __construct(PDO $connection, $idCategorie = null){

        $this->c = $connection;
        $result = $this->c->query("SELECT * FROM library_Categorie WHERE Id_categorie=".$idCategorie);

        if($result!=null){
            $result = $result->fetch(\PDO::FETCH_ASSOC);

            $this->idCategorie = $result["id_Categorie"];
            $this->name = $result["nomCategorie"];
            $this->description = $result["description"];
        }

    }

    public function getIdCategory() {
        return $this->idCategory;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }



}
?>

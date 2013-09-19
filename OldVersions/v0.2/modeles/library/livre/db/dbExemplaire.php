<?php


namespace Modele\library\livre\db;

use OWeb\Type\Modele;

use Modele\library\livre\livres;

/**
 * @author oliver
 */
class dbExemplaire extends Modele{

    private $c;

    private $Id_Exemplaire;
    private $Livre = null;
    private $Id_Lang;
    private $Nom_Livre;
    private $Edition;
    private $Date_Achat;
    private $nb_Exemplaire;


    function __construct(PDO $connection, $idExemplaire = null, dbLivre $livre = null){

        $this->c = $connection;
        $result = $this->c->query("SELECT * FROM library_livre_Exemplaire WHERE Id_Exemplaire=".$idExemplaire);

        if($result!=null){
            $result = $result->fetch(\PDO::FETCH_ASSOC);

            $this->Id_Exemplaire = $result["Id_Exemplaire"];
            if($result["Id_Livre"]!=null)
                $this->Livre = $result["Id_Livre"];

            $this->Nom_Livre = $result["Nom_Livre"];
            $this->Edition = $result["Edition"];
            $this->Date_Achat = $result["Date_Achat"];
            $this->nb_Exemplaire = $result["nb_Exemplaire"];
          
        }
    }

    public function getId_Exemplaire() {
        return $this->Id_Exemplaire;
    }

    public function setId_Exemplaire($Id_Exemplaire) {
        $this->Id_Exemplaire = $Id_Exemplaire;
    }

    public function getLivre() {
        if($this->Livre == null)
            $this->Livre = livres::getLivre($result["Id_Livre"]);
        
        return $this->Livre;
    }

    public function setLivre(dbLivre $Livre) {
        $this->Livre = $Livre;
    }

    public function getId_Lang() {
        return $this->Id_Lang;
    }

    public function setId_Lang($Id_Lang) {
        $this->Id_Lang = $Id_Lang;
    }

    public function getNom_Livre() {
        return $this->Nom_Livre;
    }

    public function setNom_Livre($Nom_Livre) {
        $this->Nom_Livre = $Nom_Livre;
    }

    public function getEdition() {
        return $this->Edition;
    }

    public function setEdition($Edition) {
        $this->Edition = $Edition;
    }

    public function getDate_Achat() {
        return $this->Date_Achat;
    }

    public function setDate_Achat($Date_Achat) {
        $this->Date_Achat = $Date_Achat;
    }

    public function getNb_Exemplaire() {
        return $this->nb_Exemplaire;
    }

    public function setNb_Exemplaire($nb_Exemplaire) {
        $this->nb_Exemplaire = $nb_Exemplaire;
    }


}
?>

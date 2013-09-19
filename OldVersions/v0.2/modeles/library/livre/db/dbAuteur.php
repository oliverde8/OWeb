<?php
namespace Modele\library\livre\db;

use OWeb\Type\Modele;

/**
 *
 * @author oliver
 */
class dbAuteur extends Modele{

    private $c;

    private $Id_Auteur;
    private $nom_Auteur;
    private $date_DeNaissance;
    private $date_DeDeces;

    private $dbAdd;
    
    function __construct(PDO $connection, $idAuteur = null){

        $this->c = $connection;

        if($idAuteur !=null){
            $result = $this->c->query("SELECT * FROM library_auteur WHERE id_Auteur=".$idAuteur);

            if($result!=null){
                $result = $result->fetch(\PDO::FETCH_ASSOC);

                $this->Id_Auteur = $result["Id_Auteur"];
                $this->nom_Auteur= $result["nomAuteur"];
                $this->date_DeDeces = $result["dateDeDeces"];
                $this->date_DeNaissance = $result["dateDeNaissance"];
            }
        }else{
            $this->dbAdd=true;
        }
    }

    public function setId_Auteur($Id_Auteur) {
        $this->Id_Auteur = $Id_Auteur;
    }

    public function setNom_Auteur($nom_Auteur) {
        $this->nom_Auteur = $nom_Auteur;
    }

    public function setPrenomAuteur($prenomAuteur) {
        $this->prenomAuteur = $prenomAuteur;
    }

    public function setDate_DeNaissance($date_DeNaissance) {
        $this->date_DeNaissance = $date_DeNaissance;
    }

    public function setDate_DeDeces($date_DeDeces) {
        $this->date_DeDeces = $date_DeDeces;
    }

    public function getId_Auteur() {
        return $this->Id_Auteur;
    }

    public function getNom_Auteur() {
        return $this->nom_Auteur;
    }

    public function getPrenomAuteur() {
        return $this->prenomAuteur;
    }

    public function getDate_DeNaissance() {
        return $this->date_DeNaissance;
    }

    public function getDate_DeDeces() {
        return $this->date_DeDeces;
    }
}
?>

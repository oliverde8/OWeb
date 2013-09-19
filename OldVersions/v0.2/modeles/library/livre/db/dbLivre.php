<?php

namespace Modele\library\livre\db;

use OWeb\Type\Modele;

use Modele\library\livre\auteurs;
use Modele\library\livre\series;
use Modele\library\categories;

/**
 * @author oliver
 */
class dbLivre extends Modele{

    private $c;

    private $auteur;
    private $serie = null;
    private $categorie;
    private $exemplaire = null;
    private $auteur_secondaire = null;

    private $Id_Livre;
    private $nomOrginal;
    private $num_Serie;
    private $ISDN;
    private $Resume;
    private $Date_de_Sortie;
    private $Commentaire;
    private $Notes;



    function __construct(\PDO $connection, $idLivre = null){

        $this->c = $connection;
        
        $result = $this->c->query("SELECT * FROM library_Livre WHERE id_Livre=".$idLivre);
        
        if($result!=null){
            $result = $result->fetch(\PDO::FETCH_ASSOC);


            $this->Id_Livre = $result["Id_Livre"];
            $this->nomOrginal = $result["nomOrginal"];
            $this->num_Serie = $result["num_Serie"];
            $this->ISDN = $result["ISDN"];
            $this->Resume = $result["Resume"];
            $this->Date_de_Sortie = $result["Date_de_Sortie"];
            $this->Commentaire = $result["Commentaire"];
            $this->Notes = $result["Notes"];

            auteurs::setConnection($this->c);
            $this->auteur = auteurs::getAuteur($result["Id_Auteur"]);

            series::setConnection($this->c);
            $this->serie = series::getSerie($result["Id_SerieLivre"]);

            categories::setConnection($this->c);
            $this->categorie = categories::getCategorie($result["Id_Categorie"]);

            $this->auteur_secondaire = new dbAuteurSecondaire($this->c, $idLivre);
            
        }

    }


    public function setAuteur(Auteur $auteur) {
        $this->auteur = $auteur;
    }

    public function setSerie(Serie $serie) {
        $this->serie = $serie;
    }

    public function setExemplaire(Exemplaire $exemplaire) {
        $this->exemplaire = $exemplaire;
    }

    public function addAuteur_secondaire(Auteur $auteur_secondaire) {
        $this->auteur_secondaire[] = $auteur_secondaire;
    }

    public function setNomOrginal($nomOrginal) {
        $this->nomOrginal = $nomOrginal;
    }

    public function setNum_Serie($num_Serie) {
        $this->num_Serie = $num_Serie;
    }

    public function setISDN($ISDN) {
        $this->ISDN = $ISDN;
    }

    public function setResume($Resume) {
        $this->Resume = $Resume;
    }

    public function setDate_dachat($Date_dachat) {
        $this->Date_dachat = $Date_dachat;
    }

    public function setCommentaire($Commentaire) {
        $this->Commentaire = $Commentaire;
    }

    public function setNotes($Notes) {
        $this->Notes = $Notes;
    }


    public function getAuteur() {
        return $this->auteur;
    }

    public function getSerie() {
        return $this->serie;
    }

    public function getExemplaire() {
        return $this->exemplaire;
    }

    public function getAuteur_secondaire() {
        return $this->auteur_secondaire;
    }

    public function getId_Livre() {
        return $this->Id_Livre;
    }

    public function getNomOrginal() {
        return $this->nomOrginal;
    }

    public function getNum_Serie() {
        return $this->num_Serie;
    }

    public function getISDN() {
        return $this->ISDN;
    }

    public function getResume() {
        return $this->Resume;
    }

    public function getDate_de_Sortie() {
        return $this->Date_de_Sortie;
    }

    public function getCommentaire() {
        return $this->Commentaire;
    }

    public function getNotes() {
        return $this->Notes;
    }


    
}
?>

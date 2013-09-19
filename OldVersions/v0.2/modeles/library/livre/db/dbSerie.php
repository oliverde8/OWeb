<?php
namespace Modele\library\livre\db;

use OWeb\Type\Modele;

/**
 *
 * @author oliver
 */
class dbSerie extends Modele{

    private $c;

    private $Id_SerieLivre;
    private $NomSerie;
    private $Id_Auteur;
    private $numSerie;

    function __construct(PDO $connection, $idSerie = null){

        $this->c = $connection;
        $result = $this->c->query("SELECT * FROM library_serie_livre WHERE Id_SerieLivre=".$idSerie);

        if($result!=null){
            $result = $result->fetch(\PDO::FETCH_ASSOC);
            
            $this->Id_SerieLivre = $result["Id_SerieLivre"];
            $this->NomSerie = $result["NomSerie"];
            $this->Id_Auteur = $result["Id_Auter"];
            $this->numSerie = $result["numSerie"];
        }

        
    }

    public function setId_SerieLivre($Id_SerieLivre) {
        $this->Id_SerieLivre = $Id_SerieLivre;
    }

    public function setNomSerie($NomSerie) {
        $this->NomSerie = $NomSerie;
    }

    public function setId_Auteur($Id_Auteur) {
        $this->Id_Auteur = $Id_Auteur;
    }

    public function setNumSerie($numSerie) {
        $this->numSerie = $numSerie;
    }

    public function getId_SerieLivre() {
        return $this->Id_SerieLivre;
    }

    public function getNomSerie() {
        return $this->NomSerie;
    }

    public function getId_Auteur() {
        return $this->Id_Auteur;
    }

    public function getNumSerie() {
        return $this->numSerie;
    }


}
?>

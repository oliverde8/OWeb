<?php

namespace OWeb\Type;

/**
 * Description of Erreur
 *
 * @author Oliver
 */
class Erreur {

    const NOTIFICATION = 'OWEB_ERR_N';
    const WARNING = 'OWEB_ERR_W';
    const FATAL = 'OWEB_ERR_F';

    private $no;
    private $text;
    private $fichier;
    private $ligne;
    
    public function __construct($no_erreur, $text_erreur, $fichier_erreur, $ligne_erreur) {

        $this->no = $no_erreur;
        $this->text = $text_erreur;
        $this->fichier = $fichier_erreur;
        $this->ligne = $ligne_erreur;
    }

    public function get_noErreur(){ 
        return $this->no;
    }

     public function get_textErreur(){
        return $this->text;
    }
    
     public function get_fichierErreur(){
        return $this->fichier;
    }

     public function get_nligneErreur(){
        return $this->ligne;
    }
}

?>

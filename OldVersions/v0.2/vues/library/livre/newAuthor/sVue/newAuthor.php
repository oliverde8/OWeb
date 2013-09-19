<?php

namespace SVue\library\livre;

use \OWeb\helpers\Form\Form;

use \OWeb\helpers\Form\Controleur\Obligatoire;
use \OWeb\helpers\Form\Controleur\Date;

class newAuthor extends Form{

    protected function init(){
        $element = $this->creeElement("nom", "Nom / Prenom Auteur :", "text");
        $element->setDescription("Le nom, le prenom de l'auteur. Un champ obligatoire");
        $element->ajouter_controleur(new Obligatoire())->setMsgErreur(Obligatoire::VIDE, "Un auteur doit avoir un nom");

        $element = $this->creeElement("naissance", "Date de Naissance Auteur :", "JqueryUi\DatePicker");
        $element->setOptions(array("maxDate" => "-5Y", 
                                    "changeYear" => "true",
                                    "changeMonth" => "true",
                                    "dateFormat" => "dd/mm/yy",
                                    "showAnim" => "slideDown"));
        $element->ajouter_controleur(new Obligatoire())
                ->setMsgErreur(Obligatoire::VIDE, "Il n'est pas nee cet Auteur? Bizzare. Un auteur doi avoir ume Date de naissance");
        $element->ajouter_controleur(new Date())->setMsgErreur(Date::INVALIDE, "Faut mettre une date, pas n'importe qoie ş");

        $element = $this->creeElement("deces", "Date de Deces de l'Auteur :", "JqueryUi\DatePicker");
        $element->setOptions(array("maxDate" => "0",
                                    "changeYear" => "true",
                                    "changeMonth" => "true",
                                    "dateFormat" => "dd/mm/yy",
                                    "showAnim" => "slideDown"));
        $element->ajouter_controleur(new Date())->setMsgErreur(Date::INVALIDE, "Faut mettre une date, pas n'importe qoie ş");

        $element = $this->creeElement("ajouter", "Ajouter", "bouton");
    }
}
?>
<?php
namespace Controleur\library\livre;

use OWeb\Type\Controleur;
use OWeb\lib\variables\enTete;

use \Modele\library\livre\livres;
use Modele\library\livre\db\dbAuteur;

//Le Formulaire
use \OWeb\helpers\Form\Form;
use \SVue\library\livre\newAuthor as FormNewAuthor;

/**
 * @author Oliver
 */
class newAuthor extends Controleur {

    private $c;

    private $formulaire;

    protected function init(){
       //$this->add_EnTete(new enTete(enTete::$Css, "articles.css"));

       $this->c = \OWeb\Gerer\Extensions::getExtension("DB\connection");
       $this->c = $this->c->get_Connection();
       
       $this->formulaire = new FormNewAuthor($this->OWeb, Form::METHOD_GET, 'livre\newAuthor');

       $this->addAction("newAuthor", "addAuthor");
    }

    protected function addAuthor(){
        $auteur = new dbAuteur($this->c, null);
    }
    protected function afficher(){
       $this->vue->formulaire = $this->formulaire;
    }
}
<?php
namespace Controleur\library;

use OWeb\Type\Controleur;
use OWeb\lib\variables\enTete;

use Modele\library\livre\livres;

/**
 * @author Oliver
 */
class home extends Controleur {

    private $c;

    protected function init(){
       //$this->add_EnTete(new enTete(enTete::$Css, "articles.css"));

       $this->c = $this->gereur_extensions->getExtension("DB\connection");
       $this->c = $this->c->get_Connection();

       livres::setConnection($this->c);
       livres::getLivre(1);

    }

    protected function afficher(){

    }
}
?>

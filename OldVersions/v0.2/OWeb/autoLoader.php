<?php

namespace OWeb;

use OWeb\Gerer\Erreur;
use OWeb\Gerer\Controleur;
use OWeb\Gerer\Extensions;
use OWeb\Gerer\Reglages;

/**
 * AutoLoader a les fonctions necessaire pour inclure les fichier modele, vues etc
 *
 * @package OWeb main
 * @author De Cramer Oliver
 */
class AutoLoader {

    public static $loader;
    public static $OWeb;
    public static $gereur_erreurs;


    /**
     *
     * @param <OWeb> $OWeb
     * @param <OWeb_main_Gerer_Erreur> $erreurs
     * @param <OWeb_main_Gerer_Controleur> $controleurs
     * @param <OWeb_main_Gerer_Plugins> $extensions
     * @return Ce retourne soit meme
     */
    public static function init(OWeb &$OWeb,
                                    Erreur &$erreurs) {
        if (self::$loader == NULL)
            self::$loader = new self();

        self::$OWeb=$OWeb;
        self::$gereur_erreurs = $erreurs;

        return self::$loader;
    }

    public function __construct() {
        spl_autoload_register(array($this, 'autoload'));
    }

    private static function autoload($class){
        $result2=explode('\\', $class);

        $result=array();
        foreach($result2 as $r){
            $r=explode('_', $r);
            foreach($r as $d){
                $result[]=$d;
            }
        }

        $res = false;
        switch ($result[0]) {
            case "Modele":
                $res = self::modele($class,$result);
                break;
            case "Controleur" :
                $res = self::controleur($class,$result);
                break;
            case "Extension" :
                $res = self::extension($class,$result);
                break;
           case "SVue" :
                $res = self::svue($class,$result);
                break;
            case "OWeb" :
                $res = self::ComposantOweb($class,$result);
                break;
        }
        return $res;
    }

    /**
     * Charge une classe d'apres son nom. A utiliser si on veu controler l'existance d'une classe
     * @param <type> $nom_class Le NOm de la classe a charger
     */
    public static function charger($nom_class){
        return self::autoload($nom_class);
    }

    /**
     * Charge un modele.
     *
     * @param <String> $modele
     * @return <Boolean> True si le modele est charger faux sinon
     */
    public static function modele($modele, $exp) {
        $class = preg_replace('/_modele$/ui','',$modele);

        //Trouver le repertoire ou il faut aller chercher
        $dir = str_replace('Modele',"",$class);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","",$dir);

        $dir = self::trouverChemin($dir, $exp);
        
        if(!$dir = self::requireFichier($dir["dir"],$dir["nomFichier"], array(OWEB_DIR_MODELES,"OWeb/defaults/modeles")))
            return false;

        spl_autoload($class);
        //Controle du parent de la classe
        if(get_parent_class($class)!="OWeb_Type_Modele"){
             trigger_error("le Modele $modele est de mauvais type. Un modele doit etre de type OWeb_Type_Modele", Erreur::FATAL);
            return false;
        }
        return true;
    }

    /**
     * Permet de charger un controleur. Faut pas oublier d'enregistre le controleur
     *
     * @param <String> $controleur
     * @return <Bool>
     */
    public static function controleur($controleur, $exp) {
        $class = preg_replace('/_Controleur/ui','',$controleur);

        //Trouver le repertoire ou il faut aller chercher
        $dir = str_replace('Controleur_',"",$class);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","",$dir);

        //Preparer les varaibles dont a besoin la calsse pour s'uato demarrer
        $OWeb=self::$OWeb;
        $erreurs=self::$gereur_erreurs;

        $dir = self::trouverChemin($dir, $exp);

        if(!self::requireFichier($dir["dir"],$dir["nomFichier"], array(OWEB_DIR_CONTROLEURS,"OWeb/defaults/controleurs"))){
            return false;
        }

        if($class instanceof \OWeb\Type\Controleur){
            throw new \OWeb\Exception("le Controleur $controleur est de mauvais type. Un Controleur doit etre de type OWeb_Type_Controleur");
            return false;
        }
        return true;
    }

    /**
     * Permet de charger l'extension. Elle va aussi automatiquement l'enregistre
     *
     * @param <type> $extension
     * @return <Bool> Si oui ou non l'extension a ete chargé
     */
    public static function extension($extension, $exp=""){
		echo $extension;
        $class = preg_replace('/_Extension/ui','',$extension);
        $extension = 'Extension\\'.$extension;

        $result2=explode('\\', $extension);

        $exp=array();
        foreach($result2 as $r){
            $r=explode('_', $r);
            foreach($r as $d){
                $exp[]=$d;
            }
        }

        //Trouver le repertoire ou il faut aller chercher
        $dir = str_replace('Extension',"",$extension);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","",$dir);

        $dir = self::trouverChemin($dir, $exp);

        if(!$dir = self::requireFichier($dir["dir"],$dir["nomFichier"], array(OWEB_DIR_EXTENSIONS,"OWeb/defaults/extensions"))){
            trigger_error("l'Extension $extension est de mauvais type. Une extension doit etre de type OWeb_Type_extension", Erreur::FATAL);
		}

        $class = $extension;
        
        //spl_autoload($class);
        $EXT = new $class(self::$OWeb, self::$gereur_erreurs, $dir);

        if(get_parent_class($EXT)!="OWeb\Type\Extension"){
            trigger_error("l'Extension $extension est de mauvais type. Une extension doit etre de type OWeb_Type_extension", Erreur::FATAL);
            return false;
        }else{
            \OWeb\Gerer\Extensions::enregistreExtension($EXT,$class);
        }
        return true;
    }

    public static function widget($controleur, $exp) {
        $class = preg_replace('/_Widgets/ui','',$controleur);

        //Trouver le repertoire ou il faut aller chercher
        $dir = str_replace('Widgets',"",$class);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","",$dir);

        //Preparer les varaibles dont a besoin la calsse pour s'uato demarrer
        $OWeb=self::$OWeb;
        $erreurs=self::$gereur_erreurs;

        $dir = self::trouverChemin($dir, $exp);
        if(!self::requireFichier($dir["dir"],$dir["nomFichier"], array(OWEB_DIR_WIDGETS,"OWeb/defaults/widgets")))
            return false;
        spl_autoload($class);

        if(get_parent_class($class)!="OWeb_Type_Widget"){
            trigger_error("le Widget $controleur est de mauvais type. Un Widget doit etre de type OWeb_Type_Modele", Erreur::FATAL);
            return false;
        }
        return true;
    }

    private static function svue($vue, $exp){
        $class = preg_replace('/_svue$/ui','',$vue);

        //Trouver le repertoire ou il faut aller chercher
        $i=1;
        $max = sizeof($exp);
        $dir = "";

        while($i < $max){
            //Regarder si pas dernier element
            if($i == ($max-1)){
                $dir.=$exp[$i]."/".OWEB_DIR_SVUES."/".$exp[$i];
            }else{
                $dir.=$exp[$i].'/';
            }

            $i++;
        }

        //Preparer les varaibles dont a besoin la calsse pour s'uato demarrer
        $OWeb=self::$OWeb;
        $erreurs=self::$gereur_erreurs;

        //inclure le fichier
        require_once OWEB_DIR_VUES.'/'.$dir.'.php';

        spl_autoload($class);
        //Controle du parent de la classe
        /*if(get_parent_class($class)!="OWeb\Type\SVue"){
            trigger_error("La SVue $vue est de mauvais type. Une Svue doit etre de type OWeb_Type_Svue", Erreur::FATAL);
            return false;
        }*/
        return true;
    }

    private static function trouverChemin($class, $ex){
        //Trouver le
        $i = 1;
        $dir='';
        while($i < sizeof($ex)){
            $dir.=$ex[$i];
            
            if($i == sizeof($ex)-1)
                $fileName = $ex[$i];
            else
                $dir.='/';
            $i++;
        }
        return (array("dir" => $dir, "nomFichier" => $fileName));
    }

    private  static function requireFichier($dir, $nom, $pref){
        foreach($pref as $p){
            //echo $p."/".$dir.".php";
            if(file_exists($p."/".$dir.".php")){
                require_once $p."/".$dir.".php";
                return $p."/".$dir.".php";
            }elseif(file_exists($p."/".$dir."/".$nom.".php")){
                require_once $p."/".$dir."/".$nom.".php";
                return $p."/".$dir."/".$nom.".php";
            }
        }
        return false;
    }

    private static function ComposantOweb($class, $explo){
       
       $res = self::OWebGeneral($class, $explo);
        
    }
    
    private static function OWeb_Default($class){
        $class = preg_replace('/_main/ui','',$class);

        //Trouver le repertoire ou il faut aller chercher
        $dir = str_replace('main',"",$class);
        $dir = str_replace('OWeb',"",$dir);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","",$dir);

        //inclure le fichier
        require_once OWEB_DIR_MAIN."/".$dir.'.php';
        spl_autoload($class);
        return true;
    }

    private static function OWebGeneral($class, $explo){
        $dir = str_replace('OWeb',"",$class);
        $dir = str_replace("_","/",$dir);
        $dir = str_replace("//","/",$dir);
        $dir = str_replace("\\","/",$dir);

        //inclure le fichier
        if(\file_exists(OWEB_DIR_MAIN.$dir.'.php')){
            require_once OWEB_DIR_MAIN.$dir.'.php';
        }else{
            require_once OWEB_DIR_MAIN.$dir.'/'.$explo[count($explo)-1].'.php';
        }
        spl_autoload($class);
        
    }

}

?>

<?php
namespace OWeb\Gerer;

/**
 * @author oliver
 */
class Langue {

    
    static private $langue=OWEB_DEFAULT_LANG;

    static private $oweb_text;
    static private $def_text;
    static private $lang_text;

    static private $charge = false;

    static public function getText($demendeur, $param){

        if(self::$charge == false)
            self::chargerLang();

        if(!\is_string($demendeur))
            $demendeur = \get_class($demendeur);

        if(isset(self::$lang_text[$demendeur][$param]))
            return self::$lang_text[$demendeur][$param];
        elseif(isset(self::$oweb_text[$demendeur][$param]))
            return self::$oweb_text[$demendeur][$param];
        else
            return false;


    }


    static public function chargerLang(){
        self::$lang_text = parse_ini_file(OWEB_DIR_LANG."/".self::$langue.".ini", true);
        self::$oweb_text = parse_ini_file(OWEB_DIR_MAIN."/defaults/langue/".self::$langue.".ini", true);
        self::$charge = true;
    }




}
?>

<?php
namespace OWeb\gerer;

use OWeb\Type\enTete as tEnTete;

/**
 *
 * @author oliver
 */
class enTete{

    const javascript = 0;
    const css = 1;
    const code = 2;

    static private $enTetes = array();
    static private $nb = 0;

    static public function ajoutEnTete($type, $code){
		$ex = \explode('/', $code);
		if(\sizeof($ex)<3){
			if($type==self::css )
				$code = \OWEB_HTML_DIR_CSS.'/'.$code;
			elseif( $type==self::javascript)
				$code = \OWEB_HTML_DIR_JS.'/'.$code;
		}

        if($type==self::javascript || $type==self::css){
            if(!isset(self::$enTetes[$code]))
                self::$enTetes[$code] = new tEnTete($type, $code);
        }else
            self::$enTetes[self::$nb] = new tEnTete($type, $code);

        self::$nb++;
    }

    static public function afficher(){
        foreach(self::$enTetes as $enTete){
            echo $enTete->getCode();
        }
    }

	static public function getEntetesLinks(){
		$l = array();
		foreach (self::$enTetes as $url => $t){
			$l[]=$url;
		}
		return $l;
	}

}
?>

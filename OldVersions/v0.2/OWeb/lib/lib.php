<?php
namespace OWeb;

/**
 * Description of lib
 *
 * @author oliver
 */
class lib {

    static public function String_to_Bool($str){
        if (strtoupper($string)=="FALSE" || $string=="0" || strtoupper($string)=="NO" || empty($string))
            return false;

        else return true;
    }


}
?>

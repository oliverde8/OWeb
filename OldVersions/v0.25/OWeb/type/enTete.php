<?php

namespace OWeb\Type;

/**
 * Description of enTete
 *
 * @author De Cramer Oliver
 */
class enTete {

    const javascript = 0;
    const css = 1;
    const code = 2;

    private $type;
    private $code;

    public function __construct($type, $code){
        
        $this->type = $type;
        
        $this->code = $code;
    }

    public function getType(){
        return $this->type;
    }

    public function getFichier(){
        return $this->fichier;
    }

    public function estJavascript(){
        if($this->type == $this::javascript)
            return true;
        else
            return false;
    }

    public function estCss(){
        if($this->type == $this::Css)
            return true;
        else
            return false;
    }

    public function estCode(){
        if($this->type == $this::code)
            return true;
        else
            return false;
    }

    public function getCode(){

        switch($this->type){

            case $this::javascript :
                $code = '<script type="text/javascript" src="'.$this->code.'"></script>'."\n";
                break;
            case $this::css :
                $code = '<link href="'.$this->code.'" rel="stylesheet" type="text/css" />'."\n";
                break;
            default :
                $code = $this->code;
        }
        return $code;
    }

}
?>

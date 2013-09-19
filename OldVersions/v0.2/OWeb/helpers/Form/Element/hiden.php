<?php

namespace OWeb\helpers\Form\Element;

/**
 *
 * @author oliver
 */
class hiden extends \OWeb\helpers\Form\Element{

    public function renderHtml($afficherErreur=false){

        $this->preparer();

        $html='    <input type="hidden" id="'.$this->id.'" '.$class.' name="'.$this->name.'" value="'.$this->valeur.'"/>'."\n";
        
        return $html;
    }

    public function preparerEnTete(){ }


}
?>

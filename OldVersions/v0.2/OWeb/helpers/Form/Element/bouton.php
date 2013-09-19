<?php

namespace OWeb\helpers\Form\Element;

/**
 *
 * @author oliver
 */
class bouton extends \OWeb\helpers\Form\Element{

    public function renderHtml($afficherErreur=false){

        $this->preparer();
        $html="";

        $html.='<div class="OWebForm_bouton'.$this->class.'" /> ';
        $html.='    <input class="OWebForm_bouton'.$this->class.'" type="submit" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->text.'"/>'."\n";
        $html.='</div>';

        return $html;
    }

    public function preparerEnTete(){ }


}
?>

<?php

namespace OWeb\helpers\Form\Element;

/**
 *
 * @author oliver
 */
class text extends \OWeb\helpers\Form\Element{

    public function renderHtml($afficherErreur=false){

        $this->preparer();

        $html="";
        foreach(self::$tags as $tag){
            $html.='<'.$tag.' id="OWebForm_Element_'.$this->id.'" class="'.$this->class.'">'."\n";
        }
       
        $html.='    <label class="OWebForm_input'.$this->class.'" for="'.$this->name.'"> '.$this->text.' </label>'."\n";
        $html.='    <input class="OWebForm_input'.$this->class.'" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->valeur.'"/>'."\n";

        $html.='    <span class="OWebForm_images'.$this->class.'">'."\n";
        
        if($this->description!=null)
            $html.='        <img src="'.OWEB_DIR_MAIN.'/defaults/sources/css/images/Helpers_Form/description.png" class="OWebForm_description_icone'.$this->class.'" alt="?" />'."\n";
        
        $html.='    </span>'."\n";

        if($this->description!=null){
            $html.='    <span class="OWebForm_description'.$this->class.'">'."\n";
            $html.='        '.$this->description."\n";
            $html.='    </span>'."\n";
        }

        if($afficherErreur && $this->y_erreur){
            $html.='    <div class="OWebForm_erreur'.$this->class.'">'."\n";
            $html.='        <ul class="OWebForm_erreur'.$this->class.'">'."\n";

            foreach($this->msgErreurs as $msg)
                $html.='            <li class="OWebForm_erreur'.$this->class.'">'.$msg.'</li>'."\n";

            $html.='        </ul>'."\n";
            $html.='    </div>'."\n";
        }

        foreach(self::$tags as $tag){
            $html.='</'.$tag.'>'."\n";
        }

        return $html;
    }

    public function preparerEnTete(){

    }


}
?>

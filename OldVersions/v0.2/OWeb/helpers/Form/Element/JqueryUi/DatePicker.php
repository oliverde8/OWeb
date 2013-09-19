<?php
namespace OWeb\helpers\Form\Element\JqueryUi;

use OWeb\Gerer\EnTete;
use OWeb\Gerer\Reglages;
/**
 *
 * @author oliver
 */
class DatePicker extends \OWeb\helpers\Form\Element\text{

    public function preparerEnTete(){

        $urls = Reglages::chargerReglage("OWeb\EnTete");

        if(!isset($urls["jquery"]))
            $urls["jquery"] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';

        if(!isset($urls["jquery-ui"]))
            $urls["jquery-ui"]='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/jquery-ui.min.js';

        if(!isset($urls["jquery-ui-css"]))
            $urls["jquery-ui-css"]= OWEB_DIR_MAIN.'/defaults/sources/css/jquery-ui/jquery-ui-1.8.9.custom.css';

        EnTete::ajoutEnTete(enTete::javascript,$urls["jquery"]);
        EnTete::ajoutEnTete(enTete::javascript,$urls["jquery-ui"]);
        EnTete::ajoutEnTete(enTete::css,$urls["jquery-ui-css"]);

        $code='<script>
	$(function() {
		$( "#'.$this->id.'" ).datepicker(';

        if(\is_array($this->options) && !empty($this->options)){
            $code.="{\n";
            $i=0;
            foreach ($this->options as $name => $opt) {
                $code.="\t\t\t ".$name.' : "'.$opt.'"';

                if($i+1 != \sizeof($this->options))
                        $code.=",\n";
                        
                $i++;
            }
            $code.="}";
        }


        $code.=');
	});
	</script>';
        
        EnTete::ajoutEnTete(enTete::code,$code);
       
    }

}
?>

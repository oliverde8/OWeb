<?php

namespace sVue;

use \OWeb\gerer\enTete;

class deuxCollone{

	function __construct() {
		enTete::ajoutEnTete(enTete::css, "2Collone.css");
	}


	public function debutCollone1(){
		echo'
<div id="twoCollone"><div>

	<div class="ColloneGauche"><div>';
	}

	public function finCollone1(){
		echo '	</div></div>';
	}

	public function debutCollone2(){
		echo '	<div class="ColloneDroite"><div>';
	}

	public function finCollone2(){
		echo '	</div></div>
	<div class="ColloneClean"></div>
</div></div>';
	}

}
?>

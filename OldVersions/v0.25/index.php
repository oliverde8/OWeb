<?php

    require_once 'OWeb/OWeb.php';
	if(!isset($_SERVER['REMOTE_ADDR']))$_SERVER['REMOTE_ADDR']="";

    $Oweb = new OWeb\OWeb($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER, $_SERVER['REMOTE_ADDR']);
    $Oweb->gogo("main");
    
    //$Oweb->fin();

?>

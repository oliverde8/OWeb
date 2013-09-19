<?php

    define('OWEB_DEFAULT_CONTROLEUR','library\home');

    require_once 'OWeb/main.php';

    if(isset($_GET["controleur"]))$_GET["controleur"]="library\\".$_GET["controleur"];

    $Oweb = new OWeb\Oweb($_GET, $_POST, $_FILES, $_SERVER);

    $Oweb->init();

    $Oweb->afficher("main");
    
    $Oweb->fin();

?>

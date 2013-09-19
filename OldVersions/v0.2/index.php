<?php

    require_once 'OWeb/main.php';

    $Oweb = new OWeb\Oweb($_GET, $_POST, $_FILES, $_SERVER);

    $Oweb->init();

    $Oweb->afficher("main");
    
    $Oweb->fin();

?>

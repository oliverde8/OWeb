<?php

    if(!defined('OWEB_DIR_MAIN'))define('OWEB_DIR_MAIN', "OWeb");
    if(!defined('OWEB_DIR_CONFIG'))define('OWEB_DIR_CONFIG', "config.ini");
    if(!defined('OWEB_DIR_LANG'))define('OWEB_DIR_LANG', "lang");
    if(!defined('OWEB_DEFAULT_LANG'))define('OWEB_DEFAULT_LANG', "fr");

    if(!defined('OWEB_DIR_VUES'))define('OWEB_DIR_VUES', "vues");
    if(!defined('OWEB_DIR_SVUES'))define('OWEB_DIR_SVUES', "sVue");
    if(!defined('OWEB_DIR_MODELES'))define('OWEB_DIR_MODELES', "modeles");
    if(!defined('OWEB_DIR_CONTROLEURS'))define('OWEB_DIR_CONTROLEURS', "controleurs");
    if(!defined('OWEB_DIR_EXTENSIONS')) define('OWEB_DIR_EXTENSIONS','extensions');
    if(!defined('OWEB_DIR_TEMPLATES')) define('OWEB_DIR_TEMPLATES','templates');

    // Les controleurs par default
    if(!defined('OWEB_DEFAULT_CONTROLEUR')) define('OWEB_DEFAULT_CONTROLEUR','home');

    // Les Fichier pour le HTML par Default
    if(!defined('OWEB_HTML_DIR_CSS')) define('OWEB_HTML_DIR_CSS','Sources/css');
    if(!defined('OWEB_HTML_DIR_JS')) define('OWEB_HTML_DIR_JS','Sources/js');

    require_once OWEB_DIR_MAIN.'/OWeb.php';
?>

<?php

namespace OWeb;

class Vue{

    private $nom;
    private $OWeb;

    function __construct($nom,OWeb &$OWeb){
         
        $this->nom = $nom;
        $this->OWeb = $OWeb;
    }

    public function afficher(){
                  
         //Faut Trouver le fichier ou ce trouve la vue
          $path = explode("\\",$this->nom);

          $i=1;
          $dir=OWEB_DIR_VUES;
          $this->nom = "vue";

          while(isset($path[$i])){
              $dir.="/".$path[$i];
              $this->nom .= "_".$path[$i];
              $i++;
          }
          $i--;
          //Et on l'inclus
          if(file_exists($dir.".php")){
              include($dir.".php");
          }else{
                include($dir."/".$path[$i].".php");
          }
    }
}




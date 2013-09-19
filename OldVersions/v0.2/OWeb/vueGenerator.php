<?php

namespace OWeb;

/**
 * Cette fonction va generer la classe d'une façon dynamique
 *
 * @author oliver
 */
class VueGenerator {

    /**
     *
     * @param <type> $vueName
     * @param <type> $params Liste des paramatres. Ces parametres seront accesible dans le fichier Vue grace a $this->. Ce tableau contien seulment le nom des parametres pas le valeur
     */
    public function init($vueName, $dir) {
        self::generer_Class($vueName, $dir);
    }

    private function generer_Class($name, $dir) {

        $class = "";
        $class.="class ".$name . " extends OWeb_Type_Vue{\n";
            $class.="\t private \$dir = '" . $dir . "';\n";
        $class.="}\n";
        echo $class;
        eval($class);
    }
}

?>

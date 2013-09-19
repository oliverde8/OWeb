<?php

namespace OWeb\Type;

/**
 * Description of Depandance
 *
 * @author oliver
 */
class Depandence {
    var $name;
    var $min_ver;
    var $max_ver;

    function Dependence($name, $min_ver, $max_ver) {
        $this->name = $name;
        $this->min_ver = $min_ver;
        $this->max_ver = $max_ver;
    }

}
?>

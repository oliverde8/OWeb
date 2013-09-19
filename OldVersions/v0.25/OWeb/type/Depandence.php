<?php

namespace OWeb\type;

/**
 * Description of Depandance
 *
 * @author oliver
 */
class Depandence {
    public $name;
    public $min_ver;
    public $max_ver;

    function __construct($name, $min_ver, $max_ver) {
        $this->name = $name;
        $this->min_ver = $min_ver;
        $this->max_ver = $max_ver;
    }

}
?>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 23/09/13
 * Time: 09:12
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types;


interface Configurable{

    public function addParams($paramName, $value);

    public function getParam($paramName);
}
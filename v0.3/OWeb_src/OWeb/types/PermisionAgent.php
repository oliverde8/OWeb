<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 22/09/13
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types;


interface PermisionAgent extends Configurable{

    public function hasPermission($action = 0);

}
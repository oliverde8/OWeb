<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 23/09/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types\temporaryData;


abstract class Data {

    private $upToDate = false;
    private $resetTime = 0;


    public abstract function setStringData();

}
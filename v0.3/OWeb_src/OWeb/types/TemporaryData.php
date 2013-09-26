<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 26/09/13
 * Time: 17:30
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types;


class TemporaryData {


   const RESET_NEVER  = -1;
   const RESET_ALWAYS = 0;

    private $upToDate = false;
    private $resetTime = 0;

    function __construct($dataName, $fileName, $resetTime){
        $this->resetTime = $resetTime;
    }


    public function setData($data){

    }

    public function isUpToDate(){
        return $this->upToDate;
    }
}
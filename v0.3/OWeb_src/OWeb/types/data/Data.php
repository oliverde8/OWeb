<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 23/09/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types\data;


abstract class Data {

    private $dataCategorie;
    private $dataId;
    private $fileName;
    private $path;

    function __construct($dataCategorie, $dataId, $fileName=null){

        $this->dataId = $dataId;
        $this->dataCategorie = $dataCategorie;

        $md5 = md5($dataId);
        if($fileName == null)
            $this->fileName = $md5.'.odata';

    }

    public static function generatePathFromId($id){

    }


}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 23/09/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types\data;


class Data {

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

        $this->path = \OWEB_DIR_DATA."/tmp/".$dataCategorie."/".self::generatePathFromId($md5);

        if(!is_dir($this->path))
            mkdir($this->path, 0, true);
    }

    public static function generatePathFromId($id){

        $path = "";

        for($i = 1; $i < strlen($id); $i = $i+2){

            $path .= $id[$i-1].$id[$i].'/';

        }

        return $path;
    }


}
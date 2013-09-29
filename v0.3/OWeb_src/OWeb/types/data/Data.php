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

    function __construct($dataCategory, $dataId, $fileName=null){

        $this->dataId = $dataId;
        $this->dataCategorie = $dataCategory;

        $md5 = md5($dataId);
        if($fileName == null)
            $this->fileName = $md5.'.odata';

        $this->path = "/tmp/".$dataCategory."/".self::generatePathFromId($md5);

        if(!is_dir($this->path))
            mkdir($this->path, 0, true);
    }

    /**
     * @param $id string
     * @return string
     */
    public static function generatePathFromId($id){

        $path = "";

        for($i = 1; $i < strlen($id); $i = $i+2){

            $path .= $id[$i-1].$id[$i].'/';

        }

        return $path;
    }

    /**
     * @param $data string
     */
    public function saveData($data){
        file_put_contents(\OWEB_DIR_DATA.$this->path.$this->fileName, $data);
    }

    /**
     * @return string
     */
    public function getData(){
        if(file_exists($this->path.$this->fileName)){
            return file_get_contents(\OWEB_DIR_DATA.$this->path.$this->fileName);
        }
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return \OWEB_DIR_DATA.$this->path;
    }

    /**
     * @return string
     */
    public function getDataCategorie()
    {
        return $this->dataCategorie;
    }

    /**
     * @return string
     */
    public function getDataId()
    {
        return $this->dataId;
    }

    /**
     * @return string
     */
    public function getUrl(){
        return \OWEB_WWW_DATA.$this->path.$this->fileName;
    }


}
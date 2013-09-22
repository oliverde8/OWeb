<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 21/09/13
 * Time: 20:04
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\utils\dataManagers;


use OWeb\utils\dataManagers\simpleIdentifiedArrays\Settings;

class SimpleIdentifiedArrays {

    protected $elementPerFile;

    protected $path;
    protected $id;
    protected $name;
    protected $decomposed_id = array();
    protected $supPath;
    protected $array;

    protected $settings;

    function __construct($name, $id){
        $this->id = $id;
        $this->name = $name;
        $this->settings = new Settings();
    }

    public function setPermissionAgentName($name){
        $this->settings->PermissionAgentName = $name;
    }

    public function setPrivate($bool){
        $this->settings->private = $bool;
    }

    public function setElementPerFile($nb){
        $this->settings->elementPerFile = $nb;
    }

    public function start(){
        //check file and create sub file.
        if(is_dir(OWEB_DIR_DATA)){
            $path = OWEB_DIR_DATA.'/'.'SimpleIdentifiedArrays'.'/'.$this->name;
            if(!is_dir($path)){
                mkdir(OWEB_DIR_DATA.'/'.'SimpleIdentifiedArrays'.'/'.$this->name);
                $data = $this->generateSettingsData();
                file_put_contents($path.'/data.oweb', $data);
            }else{
                $this->settings = $this->getSettings(OWEB_DIR_DATA.'/'.'SimpleIdentifiedArrays'.'/'.$this->name);
            }
            $this->decomposeId($this->id);
            $this->findPath($this->decomposed_id);
        }
    }

    protected function generateSettingsData(){
        return serialize($this->settings);
    }

    protected function getSettings($path){
        return unserialize(file_get_contents($path));
    }

    protected function decomposeId($id){
        $this->decomposed_id = array();
        do{
            $i = $id/10;
            $this->decomposed_id[] = $id - ($i*10);
            $id = $i;
        }while($id > 0);
        $this->decomposed_id = array_reverse($this->decomposed_id);
    }

    protected function findPath($decomposed_id){

        $size = sizeof($decomposed_id);
        $path = 0;
        for($i=0; $i < $size; $i++){
            $path .= '/'.$decomposed_id[$i];
        }
        $this->supPath = $this->path.$path;
    }


    public function addData($data){

        //Incoming data, where to put this s***
        //Let's see what data we saved before in the db
        $info = $this->loadInfo();
        if($info == null){

        }
    }

    public function loadInfo(){
        if(file_exists($this->supPath.'/info.xml')){
            return simplexml_load_file($this->supPath.'/info.xml');
        }else{
            return null;
        }
    }
}
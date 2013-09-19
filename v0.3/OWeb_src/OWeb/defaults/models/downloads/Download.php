<?php

namespace Model\downloads;


/**
 * Description of Download
 *
 * @author oliverde8
 */
class Download {
	
	private $ext_connection;
	
	private $id;
	private $name;
	private $url;
	private $isLocal;
	private $nbDownload;
	
	function __construct($id) {
		$this->ext_connection = \OWeb\manage\Extensions::getInstance()->getExtension('db\Connection');
		
		$connection = $this->ext_connection->get_Connection();
		$prefix = $this->ext_connection->get_prefix();
		
		$sql = $connection->prepare("SELECT * 
						FROM " . $prefix . "downloads
						WHERE id_download = :id");
		
		if($sql->execute(array(':id'=>$id))){
			if($result = $sql->fetchObject()){
				$this->id = $id;
				$this->name = $result->name;
				$this->url = $result->url;
				$this->isLocal = $result->isLocal;
				$this->nbDownload = $result->nbDownload;
			}else{
				throw new \Model\downloads\exception\DownloadCantBeFind("Download with id : $id doesen't exist SQL ERROR2");
			}
		}else{
			throw new \Model\downloads\exception\DownloadCantBeFind("Couldn't get Download with id : $id . SQL ERROR2");
		}
		
	}
	
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getUrl() {
		return $this->url;
	}

	public function getIsLocal() {
		return $this->isLocal;
	}

	public function getNbDownload() {
		return $this->nbDownload;
	}

	public function newDownload(){
		$connection = $this->ext_connection->get_Connection();
		$prefix = $this->ext_connection->get_prefix();
		
		$sql = $connection->prepare("UPDATE " . $prefix . "downloads
						SET nbDownload = nbDownload+1
						WHERE id_download = :id");
		$sql->execute(array(':id'=>$this->id));
	}
	
}

?>

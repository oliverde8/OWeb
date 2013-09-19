<?php

namespace Controller\downloads;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of download
 *
 * @author oliverde8
 */
class Download extends \OWeb\types\Controller{

	private $download;
	
	public function init() {
		$this->addAction("dwld", "dwld");
	}
	
	private function min(){
		if(is_numeric($this->getParam("id"))){
			$this->download = new \Model\downloads\Download($this->getParam("id"));
		}else{
			throw new \Model\downloads\exception\DownloadCantBeFind("No Download ID given");
		}
	}
	
	public function dwld(){
		$this->min();
		if(is_numeric($this->getParam("id"))){
			$this->download->newDownload();
			if($this->download->getIsLocal()){
				
				$url = (OWEB_DIR_DATA."/downloads/".$this->download->getUrl());
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'. basename($url) .'";');
				readfile($url);
			}else{
				$url = (OWEB_DIR_DATA."/downloads/".$this->download->getUrl());
				header("Content-Disposition: attachment; filename=" . basename($url));    
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Description: File Transfer");             
				header("Content-Length: " . filesize($url));
				flush(); // this doesn't really matter.

				$fp = fopen($url, "r"); 
				while (!feof($fp))
				{
					echo fread($fp, 65536); 
					flush(); // this is essential for large downloads
				}  
				fclose($fp); 
			}
		}else{
			throw new \Model\downloads\exception\DownloadCantBeFind("No Download ID given");
		}
		
		
		
	}

	public function onDisplay() {
		$this->min();
		$this->view->dwld = $this->download;
	}
}

?>

<?php

namespace Controller\OWeb\widgets;

/**
 * This Controller allows you to display a Tree Element as a html list. 
 * 
 * @params link : The link that needs to be generaterd. The link will be as such = link + ElementId
 * @params categories : The Class that has All the root elements
 * @params class : The CSS class each element should have
 * @params classes : The CSS class array for affecting different classes to different depths of the tree
 * @prams showHidden : Should the hidden tree elements be shown? 
 *
 * @author De Cramer Oliver
 */
class TreeList extends \OWeb\types\Controller{
	
	
	public function init() {
		
	}

	public function onDisplay() {
		
		$this->view->link = $this->getParam("link");
		$this->view->tree = $this->getParam("tree");
		$this->view->class = $this->getParam("class");
		$this->view->classes = $this->getParam("classes");
		$this->view->showHidden = strtolower($this->getParam("showHidden")) == 'true';
		
		if($this->view->tree instanceof \Model\OWeb\treeElement\TreeManager)
			$this->view->root = $this->view->tree->getAllRoot();
		else{
			throw new \OWeb\Exception('TreeList needs a TreeManager to show the Tree');
		}
	}
}

?>

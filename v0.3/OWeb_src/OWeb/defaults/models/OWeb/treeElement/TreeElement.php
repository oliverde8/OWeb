<?php

namespace Model\OWeb\treeElement;

/**
 * Description of TreeElement
 *
 * @author De Cramer Oliver
 */
abstract class TreeElement {
	
	protected $id;
	protected $name;
	protected $visible;
	
	protected $childrens = array();
	
	function __construct($id, $name, $visible) {
		$this->id = $id;
		$this->name = $name;
		$this->visible = $visible;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function isVisible() {
		return $this->visible;
	}

	public function setVisible($visible) {
		$this->visible = $visible;
	}

	abstract public function getParent();
	
	abstract public function getChildrens();
	
	public function getRecursiveParentsIds($ids = ""){
		if($this->getParent() != null){
			if($ids == "")
				$ids .= " ".$this->id;
			else 
				$ids .= ", ".$this->id;
			return $this->parent->getRecursiveParentsIds($ids);
		}else
			return $ids;
	}
	
	public function getRecuriveChildrensIds($ids = ""){
		
		$this->getChildrens();
			
		foreach($this->childrens as $child){
			if($ids != "")
				$ids .= ", ";
			$ids .= $child->getId();
			$ids = $child->getRecuriveChildrensIds($ids);
		}

		return $ids;
	}

}

?>

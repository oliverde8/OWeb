<?php

namespace Model\OWeb\treeElement;

/**
 * Description of TreeManager
 *
 * @author De Cramer Oliver
 */
interface TreeManager{
	
	
	public function getElement($id);
	
	public function getAllRoot();
	
	public function getChildrenOf($id);
	
	public function getAll();
}

?>

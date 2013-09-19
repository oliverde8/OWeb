<?php

namespace Model\programs;

/**
 * Description of Categories
 *
 * @author De Cramer Oliver
 */
class Categories implements \Model\OWeb\treeElement\TreeManager{

	private $ext_connection;
	
	private $elements = array();
	private $childrends = array();
	private $done = false;

	function __construct() {

		$this->ext_connection = \OWeb\manage\Extensions::getInstance()->getExtension('db\Connection');
	}

	public function getElement($id) {
		if (isset($this->elements[$id]))
			return $this->elements[$id];
		else{
			try {
				if(!$this->done){
					$this->getAll();
					return $this->getElement($id);
				}else
					throw new \Model\programs\exception\CategoryNotFound("The category with the id $id coulsn't be found : Category with this id don't exist.");
			} catch (\Exception $ex) {
				throw new \Model\programs\exception\CategoryNotFound("The category with the id $id couldn't be found : Unknown Error.", 0, $ex);
			}
		}
	}

	public function getAllRoot() {
		if(!$this->done)
			$this->getAll ();
		return($this->getChildrenOf(-1));
	}

	public function getChildrenOf($id){
		if(isset($this->childrends[$id]))
			return $this->childrends[$id];
		else
			return array();
	}
	
	public function getAll(){
		
		$connection = $this->ext_connection->get_Connection();
		$prefix = $this->ext_connection->get_prefix();
		$this->done = true;
		try{
			$sql = "SELECT * FROM " . $prefix . "program_category ORDER BY title ASC";
			if($sql = $connection->query($sql)){
				$sql_res = $sql->fetchAll();
				
				if(is_array($sql_res)){
					foreach($sql_res as $res_el){
						$element = new CategorieElement($this, $res_el['id_category'], $res_el['title'], $res_el['description'], $res_el['parent_id'],  $res_el['img']);

						$this->elements[$res_el['id_category']]=$element;
						$this->childrends[$res_el['parent_id']][] = $element;
					}
				}
			}else
				throw new \Model\programs\exception\CategoryNotFound("Couldn't load All categories. SQL ERROR");
		}catch(\Exception $ex){
			throw new \Model\programs\exception\CategoryNotFound("Couldn't load All categories. SQL ERROR", 0, $ex);
		}
	}

}

?>

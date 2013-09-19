<?php

namespace Model\programs;

/**
 * Description of Programs
 *
 * @author oliverde8
 */
class Programs {
	
	private $ext_connection;
	
	private $categories;
	private $articles;
	
	private $programs = array();
	
	function __construct(\Model\programs\Categories $cat, \Model\articles\Artciles $art) {
		$this->ext_connection = \OWeb\manage\Extensions::getInstance()->getExtension('db\Connection');
		$this->categories = $cat;
		$this->articles = $art;
	}
	
	public function getprogram($id){
		
		if(isset($this->programs[$id]))
			return $this->programs[$id];
		else{
			
			try{
				$connection = $this->ext_connection->get_Connection();
				$prefix = $this->ext_connection->get_prefix();
				
				$sql = $connection->prepare("SELECT * 
						FROM " . $prefix . "program p, 
						WHERE id_prog = :id");
				
				if($sql->execute(array(':id'=>$id))){
					$result = $sql->fetchObject();
					
					$article = null;
					try{
						
					}catch(\Exception $ex){
						$article = $this->articles->getArticle($result->desc_id);
					}
					
					$program = 
						new \Model\programs\Program	(
										$result->id_prog,
										$result->name, 
										$result->img, 
										$result->front_page == 1, 
										$this->categories->getElement($result->cat_id), 
										$article, 
										$result->date, 
										$result->short_desc,
										$result->short_desc2
						); 
					$this->programs[$id] = $article;
					
					return $program;
				}else{
					throw new \Model\articles\exception\ArticleNotFound("Couldn't get Article with id : $id . SQL ERROR2", 0, $ex);
				}
				
			}catch(\Exception $ex){
				throw new \Model\articles\exception\ArticleNotFound("Couldn't get Article with id : $id . SQL ERROR", 0, $ex);
			}
		}
	}
	
	public function getProgramArticles(\Model\programs\CategorieElement $cat, $start, $nbELement, $rec = true){
		try{
			$connection = $this->ext_connection->get_Connection();
			$prefix = $this->ext_connection->get_prefix();
			
			$cs = $cat->getChildrens();
			if($rec && !empty($cs)){
				$cat_parents = $cat->getRecuriveChildrensIds();
				
				$sql = "SELECT * 
						FROM " . $prefix . "program
						WHERE cat_id IN ($cat_parents)
					ORDER BY date DESC
					LIMIT $start, $nbELement";
			}else
				$sql = "SELECT * 
						FROM " . $prefix . "program
						WHERE cat_id = ".$cat->getId()."
					ORDER BY pdate DESC
					LIMIT $start, $nbELement";
			
			if($sql = $connection->query($sql)){
				
				$programs = array();
				$program_ids = "";
				while($result = $sql->fetchObject()){
					
					$article = null;
					try{
						
					}catch(\Exception $ex){
						$article = $this->articles->getArticle($result->desc_id);
					}
					
					if(isset($this->programs[$result->id_prog])){
						$programs[$result->id_prog] = $this->programs[$result->id_prog];
					}else{

						$programs[$result->id_prog]  = 
							new \Model\programs\Program	(
											$result->id_prog,
											$result->name, 
											$result->img, 
											$result->front_page == 1, 
											$this->categories->getElement($result->cat_id), 
											$article, 
											$result->date, 
											$result->short_desc,
											$result->short_desc2
								);
						$this->programs[$result->id_prog] = $programs[$result->id_prog] ;
					}
					$program_ids = $result->id_prog.",";
				}
				
				$program_ids = substr($program_ids, 0, strlen($program_ids)-1);
				
				/*$sql = "SELECT * FROM " . $prefix . "article_category_more
								WHERE article_id IN ( $article_ids) ";
				if($sql = $connection->query($sql)){
					while($result = $sql->fetchObject()){
						if(!$programs[$result->article_id]->isDone())
							$programs[$result->article_id]->addCategorie($this->categories->getElement($result->category_id));
					}
				}
				
				$sql = "SELECT * FROM " . $prefix . "article_attribute
								WHERE article_id IN ( $article_ids) ";
				if($sql = $connection->query($sql)){
					while($result = $sql->fetchObject()){
						if(!$programs[$result->article_id]->isDone())
							$programs[$result->article_id]->addAttribute($result->name, $result->value);
					}
				}*/
				
				return $programs;
			}else{
				throw new \Model\articles\exception\ArticleNotFound("Couldn't get Articles of Category : ".$cat->getId()." . SQL ERROR2", 0, $ex);
			}
			
		}catch(\Exception $ex){
			throw new \Model\articles\exception\ArticleNotFound("Couldn't get Articles of Category : ".$cat->getId()." . SQL ERROR", 0, $ex);
		}
	
	}
	
}

?>

<?php

namespace Model\articles;

/**
 * Description of Artciles
 *
 * @author De Cramer Oliver
 */
class Artciles {
	
	private $ext_connection;
	private $categories;
	
	private $articles = array();
	
	function __construct(\Model\articles\Categories $cat) {
		$this->ext_connection = \OWeb\manage\Extensions::getInstance()->getExtension('db\Connection');
		$this->categories = $cat;
	}
	

	public function getArticle($id){
		
		if(isset($this->articles[$id]))
			return $this->articles[$id];
		else{
			
			try{
				$connection = $this->ext_connection->get_Connection();
				$prefix = $this->ext_connection->get_prefix();
				
				$sql = $connection->prepare("SELECT * 
						FROM " . $prefix . "article_article aa, " . $prefix . "article_content ac
						WHERE ac.article_id = id_article 
						AND id_article = :id");
				
				if($sql->execute(array(':id'=>$id))){
					$result = $sql->fetchObject();
					$article = 
						new \Model\articles\Article	(
										$result->id_article, 
										$result->type, 
										$result->img, 
										$result->published == 1, 
										$result->pdate, 
										$this->categories->getElement($result->category_id)
						); 
					$this->articles[$id] = $article;
					
					$article->addLanguage($result->article_lang, $result->title,  $result->content);
					while($result = $sql->fetchObject()){
						$article->addLanguage($result->article_lang, $result->title,  $result->content);
					}
					
					$sql = "SELECT * FROM " . $prefix . "article_category_more
								WHERE article_id = $id";
					if($sql = $connection->query($sql)){
						while($result = $sql->fetchObject()){
							$article->addCategorie($this->categories->getElement($result->category_id));
						}
					}
					$sql = "SELECT * FROM " . $prefix . "article_attribute
								WHERE article_id = $id";
					if($sql = $connection->query($sql)){
						while($result = $sql->fetchObject()){
							$article->addAttribute($result->name, $result->value);
						}
					}
					$article->setisDOne(true);
					return $article;
				}else{
					throw new \Model\articles\exception\ArticleNotFound("Couldn't get Article with id : $id . SQL ERROR2", 0, $ex);
				}
				
			}catch(\Exception $ex){
				throw new \Model\articles\exception\ArticleNotFound("Couldn't get Article with id : $id . SQL ERROR", 0, $ex);
			}
		}
	}
	
	public function getNbCategoryArticles(\Model\articles\CategorieElement $cat, $rec = true){
		
		try{
			$connection = $this->ext_connection->get_Connection();
			$prefix = $this->ext_connection->get_prefix();
			
			$cs = $cat->getChildrens();
			if($rec && !empty($cs)){
				$cat_parents = $cat->getRecuriveChildrensIds();
				
				$sql = "SELECT COUNT(*) as nb
						FROM " . $prefix . "article_article aa
						WHERE id_article IN (SELECT acm.article_id 
														FROM " . $prefix . "article_category_more acm 
														WHERE acm.category_id = ".$cat->getId()." )
								OR category_id = ".$cat->getId()."
								OR id_article IN (SELECT acm.article_id 
														FROM " . $prefix . "article_category_more acm 
														WHERE acm.category_id IN ($cat_parents))
								OR category_id IN ($cat_parents)";
				//return;
			}else
				$sql = "SELECT COUNT(*) as nb
						FROM " . $prefix . "article_article aa
						WHERE id_article IN (SELECT acm.article_id 
													FROM " . $prefix . "article_category_more acm 
													WHERE acm.category_id = ".$cat->getId()." )
							OR category_id = ".$cat->getId()."";
			
			if($sql = $connection->query($sql)){

				if($result = $sql->fetchObject()){
					return $result->nb;
				}
			}
		}catch(\Exception $ex){
			throw new \Model\articles\exception\ArticleNotFound("Couldn't get Nb Articles of Category : ".$cat->getId()." . SQL ERROR", 0, $ex);
		}
	}
	
	public function getCategoryArticles(\Model\articles\CategorieElement $cat, $start, $nbELement, $rec = true){
		
		try{
			$connection = $this->ext_connection->get_Connection();
			$prefix = $this->ext_connection->get_prefix();
			
			$cs = $cat->getChildrens();
			if($rec && !empty($cs)){
				$cat_parents = $cat->getRecuriveChildrensIds();
				
				$sql = "SELECT id_article
						FROM " . $prefix . "article_article aa
						WHERE id_article IN (SELECT acm.article_id 
														FROM " . $prefix . "article_category_more acm 
														WHERE acm.category_id = ".$cat->getId()." )
								OR category_id = ".$cat->getId()."
								OR id_article IN (SELECT acm.article_id 
														FROM " . $prefix . "article_category_more acm 
														WHERE acm.category_id IN ($cat_parents))
								OR category_id IN ($cat_parents)
						ORDER BY pdate DESC
						LIMIT $start, $nbELement";
				//return;
			}else
				$sql = "SELECT id_article
						FROM " . $prefix . "article_article aa
						WHERE id_article IN (SELECT acm.article_id 
													FROM " . $prefix . "article_category_more acm 
													WHERE acm.category_id = ".$cat->getId()." )
							OR category_id = ".$cat->getId()."
						ORDER BY pdate DESC
						LIMIT $start, $nbELement";
			
			
			if($sql = $connection->query($sql)){
				
				$articles = array();
				$article_ids = "";
				while($result = $sql->fetchObject()){
					$article_ids .= $result->id_article." ,";
				}
				
				$article_ids = substr($article_ids, 0, strlen($article_ids)-1);
			}
			
			$sql = "SELECT * 
						FROM " . $prefix . "article_article aa, " . $prefix . "article_content ac
						WHERE ac.article_id = id_article 
							AND id_article IN ($article_ids)
					ORDER BY pdate DESC";
			
			if($sql = $connection->query($sql)){
				
				$articles = array();
				while($result = $sql->fetchObject()){
					if(isset($this->articles[$result->id_article]) && !isset($articles[$result->id_article]))
						$articles[$result->id_article] = $this->articles[$result->id_article];
					
					else if(!isset($articles[$result->id_article])){
						$articles[$result->id_article] = 	
								new \Model\articles\Article	(
										$result->id_article, 
										$result->type, 
										$result->img, 
										$result->published == 1, 
										$result->pdate, 
										$this->categories->getElement($result->category_id)
									); 
						
						$this->articles[$result->id_article] = $articles[$result->id_article];
					}
					if(!$articles[$result->id_article]->isDone()){

						$articles[$result->id_article]->addLanguage($result->article_lang, $result->title,  $result->content);
					}
				}	
				
				$sql = "SELECT * FROM " . $prefix . "article_category_more
								WHERE article_id IN ( $article_ids) ";
				if($sql = $connection->query($sql)){
					while($result = $sql->fetchObject()){
						if(!$articles[$result->article_id]->isDone())
							$articles[$result->article_id]->addCategorie($this->categories->getElement($result->category_id));
					}
				}
				
				$sql = "SELECT * FROM " . $prefix . "article_attribute
								WHERE article_id IN ( $article_ids) ";
				if($sql = $connection->query($sql)){
					while($result = $sql->fetchObject()){
						if(!$articles[$result->article_id]->isDone())
							$articles[$result->article_id]->addAttribute($result->name, $result->value);
					}
				}
				
				if(is_array($articles))
					foreach ($articles as $article)
						$article->setisDOne (true);

				return $articles;
			}else{
				throw new \Model\articles\exception\ArticleNotFound("Couldn't get Articles of Category : ".$cat->getId()." . SQL ERROR2", 0);
			}
			
		}catch(\Exception $ex){
			throw new \Model\articles\exception\ArticleNotFound("Couldn't get Articles of Category : ".$cat->getId()." . SQL ERROR", 0, $ex);
		}
	
	}
	
	public function getArticleByNameCategory($name, \Model\articles\CategorieElement $cat){
		$connection = $this->ext_connection->get_Connection();
		$prefix = $this->ext_connection->get_prefix();

		$sql = "SELECT *
				FROM " . $prefix . "article_article aa, " . $prefix . "article_content ac
				WHERE ac.article_id = id_article 
				AND ac.title = '".$name."'
				AND (aa.category_id = ".$cat->getId()."
					OR id_article IN (SELECT acm.article_id 
													FROM " . $prefix . "article_category_more acm 
													WHERE acm.category_id = ".$cat->getId()." ))";

		if($sql = $connection->query($sql)){
			$result = $sql->fetchObject();
			$article = 
				new \Model\articles\Article	(
								$result->id_article, 
								$result->type, 
								$result->img, 
								$result->published == 1, 
								$result->pdate, 
								$this->categories->getElement($result->category_id)
				); 
			$this->articles[$result->id_article] = $article;
			$id = $result->id_article;
			
			$article->addLanguage($result->article_lang, $result->title,  $result->content);
			while($result = $sql->fetchObject()){
				$article->addLanguage($result->article_lang, $result->title,  $result->content);
			}

			$sql = "SELECT * FROM " . $prefix . "article_category_more
						WHERE article_id = $id";
			if($sql = $connection->query($sql)){
				while($result = $sql->fetchObject()){
					$article->addCategorie($this->categories->getElement($result->category_id));
				}
			}
			$sql = "SELECT * FROM " . $prefix . "article_attribute
						WHERE article_id = $id";
			if($sql = $connection->query($sql)){
				while($result = $sql->fetchObject()){
					$article->addAttribute($result->name, $result->value);
				}
			}
			$article->setisDOne(true);
			return $article;
		}
		
		
	}
	
}

?>

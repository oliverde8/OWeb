<?php

namespace controleur\myBooks;

use OWeb\Type\Controleur;
use OWeb\Gerer\enTete;

/**
 * @author Oliver
 */
class home extends Controleur {

	private $vue_deuxCollone;

	protected function init() {
		$this->vue_deuxCollone = new \sVue\deuxCollone();
		$this->addEnTete(enTete::css, "myBooks.css");

		$this->ajoutDepandence('DB\connection');
	}

	protected function afficher() {
		$this->vue->vue_deuxCollone = $this->vue_deuxCollone;

		$this->connection = $this->ext_DB_connection->get_Connection();
		$this->readBooksCollectorXML();
	}

	private function readBooksCollectorXML() {

		$xml = file_get_contents('C:\Users\Oliver\Desktop\testt.xml');
		$xmlo = simplexml_load_string($xml);

		foreach($xmlo->booklist->book as $book){
			echo $book->isbn.'-';
			//$book = $xmlo->booklist->book[0];
			
			$authorID = array();
			foreach ($book->mainsection->credits->credit as $person)
				$authorID[] = $this->addAuthorIfMising($person->person->displayname);

			if (isset($book->mainsection->series) && !empty($book->mainsection->series))
				$serieID = $this->addSerieIfMissing($book->mainsection->series, $authorID[0]);
			else
				$serieID = 'NULL';

			$genreID = array();
			foreach ($book->genres->genre as $genre)
				$genreID[] = $this->addGenrerIfMising($genre->displayname);

			if (isset($book->location->displayname) && !empty($book->location->displayname))
				$locationID = $this->addLocationIfMissing($book->location->displayname);
			else
				$locationID = 'NULL';

			//ADDING THE BOOK
			$prefix = $this->ext_DB_connection->get_prefix();
			$sql = "SELECT * FROM " . $prefix . "mybooks_books
						WHERE book_name=" . $this->connection->quote($book->mainsection->title) . "
								AND book_mainauthorID = ".$authorID[0];
			if ($sql = $this->connection->query($sql)) {
				if ($sql->rowCount() > 0) {
					$res = $sql->fetchAll();
					$book_ID = $res[0]['book_ID'];
				}else{
					if(!isset($book->mainsection->original->origtitle))
							$book->mainsection->original->origtitle = "";
					
					if(!$this->connection->query("INSERT INTO mybooks_books(book_ISBN,
																		book_name,
																		book_fullname,
																		book_orginalName,
																		book_mainauthorID,
																		book_serieID,
																		book_serieIndex,
																		book_language,
																		book_publicationDate,
																		book_locationID,
																		book_quantity,
																		book_pagecount)
												VALUES(".$this->connection->quote($book->isbn).",
														".$this->connection->quote($book->mainsection->title).",
														".$this->connection->quote($book->mainsection->title).",
														".$this->connection->quote($book->mainsection->original->origtitle).",
														".$authorID[0].",
														".$serieID.",
														".$this->connection->quote($book->volume->sortname).",
														".$this->connection->quote($book->language->displayname).",
														'',
														".$locationID.",
														".$this->connection->quote($book->quantity).",
														".$this->connection->quote($book->mainsection->pagecount)."	)")){
						
					}
					$book_ID = $this->connection->lastInsertId();
				}
			}

			foreach($authorID as $k=>$v){
				if($k!=0)
					$this->connection->query("INSERT INTO mybooks_bookauthors
														VALUES($v, $book_ID)");
			}

			foreach($genreID as $k=>$v){
				if($k!=0)
					$this->connection->query("INSERT INTO mybooks_bookgenres
														VALUES($book_ID, $v)");
			}
			

		}
	}

	private function addAuthorIfMising($name) {
		$prefix = $this->ext_DB_connection->get_prefix();
		$sql = "SELECT * FROM " . $prefix . "mybooks_authors WHERE author_NomAffiche=" . $this->connection->quote($name) . "";
		if ($sql = $this->connection->query($sql)) {
			if ($sql->rowCount() > 0) {
				$res = $sql->fetchAll();
				return $res[0]['author_ID'];
			}
		}

		$this->connection->query("INSERT INTO mybooks_authors(author_NomAffiche, author_Nom, author_description)
									VALUES(" . $this->connection->quote($name) . ", " . $this->connection->quote($name) . ", 'empty')");

		return $this->connection->lastInsertId();
	}

	private function addSerieIfMissing($serie, $authID) {
		$prefix = $this->ext_DB_connection->get_prefix();
		$sql = "SELECT * FROM " . $prefix . "mybooks_series WHERE bookserie_name=" . $this->connection->quote($serie->displayname) . "";
		if ($sql = $this->connection->query($sql)) {
			if ($sql->rowCount() > 0) {
				$res = $sql->fetchAll();
				return $res[0]['bookserie_ID'];
			}
		}
		if ($serie->complete == 'No')
			$complete = 0;
		else
			$complete = 1;

		$this->connection->query("INSERT INTO mybooks_series(bookserie_name, bookserie_author, bookserie_finished, bookserie_nbbooks)
			VALUES(" . $this->connection->quote($serie->displayname) . ", $authID, $complete, 0)");
		return $this->connection->lastInsertId();
	}

	private function addGenrerIfMising($name) {
		$prefix = $this->ext_DB_connection->get_prefix();
		$sql = "SELECT * FROM " . $prefix . "mybooks_genres WHERE genre_name=" . $this->connection->quote($name) . "";
		if ($sql = $this->connection->query($sql)) {
			if ($sql->rowCount() > 0) {
				$res = $sql->fetchAll();
				return $res[0]['genre_ID'];
			}
		}

		$this->connection->query("INSERT INTO mybooks_genres(genre_name)
									VALUES(" . $this->connection->quote($name) . ")");

		return $this->connection->lastInsertId();
	}

	private function addLocationIfMissing($name) {
		$prefix = $this->ext_DB_connection->get_prefix();
		$sql = "SELECT * FROM " . $prefix . "mybooks_locations WHERE location_Name=" . $this->connection->quote($name) . "";
		if ($sql = $this->connection->query($sql)) {
			if ($sql->rowCount() > 0) {
				$res = $sql->fetchAll();
				return $res[0]['location_ID'];
			}
		}

		$this->connection->query("INSERT INTO mybooks_locations(location_Name)
									VALUES(" . $this->connection->quote($name) . ")");

		return $this->connection->lastInsertId();
	}

}

?>

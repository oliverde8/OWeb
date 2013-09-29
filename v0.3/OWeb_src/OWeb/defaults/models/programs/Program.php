<?php

namespace Model\programs;

/**
 * Description of Programs
 *
 * @author oliverde8
 */
class Program {
	
	protected $id;
	protected $name;
	protected $img;
	protected $front_page;
	protected $category;
	protected $desc_article;
	protected $date;

    protected $short = array();
    protected $vshort = array();

	protected $versions = array();
	protected $complementary = array();
	
	function __construct($id, $name, $img, $front_page, $category, $desc_article, $date) {
		$this->id = $id;
		$this->name = $name;
		$this->img = $img;
		$this->front_page = $front_page;
		$this->category = $category;
		$this->desc_article = $desc_article;
		$this->date = $date;
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}
	
	public function getImg() {
		return $this->img;
	}

	public function setImg($img) {
		$this->img = $img;
	}

	public function getFront_page() {
		return $this->front_page;
	}

	public function setFront_page($front_page) {
		$this->front_page = $front_page;
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory($category) {
		$this->category = $category;
	}

	public function getDesc_article() {
		return $this->desc_article;
	}

	public function setDesc_article($desc_article) {
		$this->desc_article = $desc_article;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date = $date;
	}

    public function addLanguage($lang, $short, $vshort){
        $this->short[$lang] = $short;
        $this->vshort[$lang] = $vshort;
    }

    public function getShortDescription($lang){
        return isset($this->short[$lang]) ? $this->short[$lang] : "";
    }

    public function getVeryShortDescription($lang){
        return isset($this->vshort[$lang]) ? $this->vshort[$lang] : "";
    }

    public function checkLang($lang){
        return (isset($this->vshort[$lang]));
    }
}

?>

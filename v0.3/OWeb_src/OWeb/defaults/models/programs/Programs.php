<?php

namespace Model\programs;
use Model\articles\Artciles;
use Model\programs\exception\ProgramNotFound;
use OWeb\manage\Extensions;

/**
 * Description of Programs
 *
 * @author oliverde8
 */
class Programs
{

    private $ext_connection;

    private $categories;
    private $articles;

    private $programs = array();

    function __construct(Categories $cat, Artciles $art)
    {
        $this->ext_connection = Extensions::getInstance()->getExtension('db\Connection');
        $this->categories = $cat;
        $this->articles = $art;
    }

    public function getprogram($id)
    {

        if (isset($this->programs[$id]))
            return $this->programs[$id];
        else {

            try {
                $connection = $this->ext_connection->get_Connection();
                $prefix = $this->ext_connection->get_prefix();

                $sql = $connection->prepare("SELECT *
						FROM " . $prefix . "program p," . $prefix . "program_description d
						WHERE id_prog = :id
						    AND prog_id = id_prog");

                if ($sql->execute(array(':id' => $id)) && $result = $sql->fetchObject()) {

                    $article = null;
                    try {
                        $article = $this->articles->getArticle($result->desc_id);
                    } catch (\Exception $ex) {
                    }

                    $program =
                        new \Model\programs\Program    (
                            $result->id_prog,
                            $result->name,
                            $result->img,
                            $result->front_page == 1,
                            $this->categories->getElement($result->article_id),
                            $article,
                            $result->date
                        );
                    $this->programs[$id] = $program;

                    do {
                        $program->addLanguage($result->lang, $result->short_desc, $result->vshort_desc);

                    } while ($result = $sql->fetchObject());

                    return $program;
                } else {
                    throw new ProgramNotFound("Couldn't get Program with id : $id . SQL ERROR2", 0);
                }

            } catch (\Exception $ex) {
                throw new ProgramNotFound("Couldn't get Program with id : $id . SQL ERROR", 0, $ex);
            }
        }
    }

    public function getPrograms(\Model\programs\CategorieElement $cat, $start, $nbELement, $rec = true)
    {
        try {
            $connection = $this->ext_connection->get_Connection();
            $prefix = $this->ext_connection->get_prefix();

            $cs = $cat->getChildrens();
            if ($rec && !empty($cs)) {
                $cat_parents = $cat->getRecuriveChildrensIds();

                $sql = "SELECT *
						FROM " . $prefix . "program p," . $prefix . "program_description d
						WHERE cat_id IN ($cat_parents)
						    AND prog_id = id_prog
					ORDER BY date DESC
					LIMIT $start, $nbELement";
            } else
                $sql = "SELECT *
						FROM " . $prefix . "program p," . $prefix . "program_description d
						WHERE cat_id = " . $cat->getId() . "
						    AND prog_id = id_prog
					ORDER BY pdate DESC
					LIMIT $start, $nbELement";

            if ($sql = $connection->query($sql)) {

                $programs = array();
                while ($result = $sql->fetchObject()) {

                    if (isset($this->programs[$result->id_prog])) {
                        $programs[$result->id_prog] = $this->programs[$result->id_prog];
                    }else if(isset($programs[$result->id_prog])){
                        $programs[$result->id_prog]->addLanguage($result->lang, $result->short_desc, $result->vshort_desc);
                    }else {
                        $article = null;
                        try {
                            $article = $this->articles->getArticle($result->article_id);
                        } catch (\Exception $ex) {
                        }

                        $programs[$result->id_prog] =
                            new \Model\programs\Program    (
                                $result->id_prog,
                                $result->name,
                                $result->img,
                                $result->front_page == 1,
                                $this->categories->getElement($result->cat_id),
                                $article,
                                $result->date
                            );
                        $programs[$result->id_prog]->addLanguage($result->lang, $result->short_desc, $result->vshort_desc);
                    }
                }
                //$this->programs[$result->id_prog] = $programs[$result->id_prog] ;
                return $programs;
            } else {
                throw new ProgramNotFound("Couldn't get Program of Category : " . $cat->getId() . " . SQL ERROR2", 0, $ex);
            }

        } catch (\Exception $ex) {
            throw new ProgramNotFound("Couldn't get Program of Category : " . $cat->getId() . " . SQL ERROR", 0, $ex);
        }

    }

}

?>

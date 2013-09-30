<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */
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

                $programs = $this->getProgramsArray(array($id));

                if(!isset($programs[$id])){
                    return $programs[$id];
                }else{
                    throw new ProgramNotFound("Couldn't get Program with id : $id . NO such program", 0);
                }

            } catch (\Exception $ex) {
                throw new ProgramNotFound("Couldn't get Program with id : $id . ERROR", 0, $ex);
            }
        }
    }


    public function getPrograms(\Model\programs\CategorieElement $cat, $start, $nbELement, $rec = true){

        try {
            $connection = $this->ext_connection->get_Connection();
            $prefix = $this->ext_connection->get_prefix();

            $cs = $cat->getChildrens();


            if ($rec && !empty($cs)) {
                $cat_parents = $cat->getRecuriveChildrensIds();

                $sql = "SELECT id_prog
                            FROM " . $prefix . "program p
                            WHERE cat_id IN ($cat_parents)
                        ORDER BY date DESC
                        LIMIT $start, $nbELement";
            } else
                $sql = "SELECT id_prog
                            FROM " . $prefix . "program p
                            WHERE cat_id = " . $cat->getId() . "
                        ORDER BY date DESC
                        LIMIT $start, $nbELement";


            if ($sql = $connection->query($sql)) {

                $programs = array();
                while ($result = $sql->fetchObject()) {
                    $programs[] = $result->id_prog;
                }

                return $this->getProgramsArray($programs);

            }else{
                throw new ProgramNotFound("Couldn't get Program of Category : " . $cat->getId() . " . SQL ERROR2", 0);
            }

        }catch (\Exception $ex) {
            throw new ProgramNotFound("Couldn't get Program of Category : " . $cat->getId() . " . SQL ERROR", 0, $ex);
        }
        return array();
    }

    public function getProgramsArray($ids){

        $idString = "";
        foreach($ids as $id){
            $idString .=$id.',';
        }
        $idString = substr($idString, 0, strlen($idString)-1);

        try {
            $connection = $this->ext_connection->get_Connection();
            $prefix = $this->ext_connection->get_prefix();

            $sql = "SELECT *
                    FROM " . $prefix . "program p," . $prefix . "program_description d
                    WHERE prog_id IN (" . $idString . ")
                        AND prog_id = id_prog
                ORDER BY date DESC";

            $programs = array();
            if ($sql = $connection->query($sql)) {

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
            } else {
                throw new ProgramNotFound("Couldn't get Program of List : ".$idString." SQL ERROR2", 0);
            }

            //Main program component gather, now let's get the rest of it.

            //First second categories
            $sql = "SELECT * FROM ".$prefix."program_category_category
                        WHERE prog_id IN (".$idString.")";

            if ($sql = $connection->query($sql)) {

                while ($result = $sql->fetchObject()) {
                    if(isset($programs[$result->prog_id])){
                        $programs[$result->prog_id]->addCategory($this->categories->getElement($result->category_id));
                    }
                }
            } else {
                throw new ProgramNotFound("Couldn't get Program of List : ".$idString." Error gathering secondary Categories", 0);
            }

            //Second secondary articles
            $sql2 = "SELECT * FROM ".$prefix."program_article
                        WHERE prog_id IN (".$idString.")";

            if ($sql = $connection->query($sql2)) {

                while ($result = $sql->fetchObject()) {
                    if(isset($programs[$result->prog_id])){
                        $programs[$result->prog_id]->addCategory($this->articles->getArticle($result->category_id));
                    }
                }
            } else {
                throw new ProgramNotFound("Couldn't get Program of List : ".$idString." Error gathering secondary Articles. ".$sql2, 0);
            }


            //Lest register the new programs in to the buffer
            foreach($programs as $id=>$program){
                $this->programs[$id] = $program;
            }


            return $programs;

        } catch (\Exception $ex) {
            throw new ProgramNotFound("Couldn't get Program of List : ".$idString." . SQL ERROR", 0, $ex);
        }

    }

}

?>

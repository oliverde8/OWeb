<?PHP

namespace Modele\library;

use OWeb\Type\Modele;

use Modele\library\db\dbCategorie;


/**
 * @author oliver
 */
class categories extends Modele{

    static private $categorie= array();
    static private $connection;

    static public function setConnection(\PDO $connection){
        self::$connection = $connection;
    }

    static public function getCategorie($idCategorie){

        if(!isset(self::$categorie[$idCategorie]))
            self::$categorie[$idCategorie] = new dbCategorie(self::$connection, $idCategorie);

        return self::$categorie[$idCategorie];

    }
}

?>
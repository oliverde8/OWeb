<?PHP

namespace Modele\library\livre;

use OWeb\Type\Modele;

use Modele\library\livre\db\dbAuteur;


/**
 * @author oliver
 */
class auteurs extends Modele{

    static private $auteurs= array();
    static private $connection;

    static public function setConnection(\PDO $connection){
        self::$connection = $connection;
    }

    static public function getAuteur($idAuteur){

        if(!isset(self::$auteurs[$idLivre]))
            self::$auteurs[$idAuteur] = new dbAuteur(self::$connection, $idAuteur);

        return self::$auteurs[$idAuteur];

    }
}

?>
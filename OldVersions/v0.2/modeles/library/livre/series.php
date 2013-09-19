<?PHP

namespace Modele\library\livre;

use OWeb\Type\Modele;

use Modele\library\livre\db\dbSerie;



/**
 *
 *
 * @author oliver
 */
class series extends Modele{

    static private $series= array();
    static private $connection;

    static public function setConnection(\PDO $connection){
        self::$connection = $connection;
    }

    static public function getSerie($idSerie){

        if(!isset(self::$series[$idSerie]))
            self::$series[$idSerie] = new dbSerie(self::$connection, $idSerie);

        return self::$series[$idSerie];

    }
}

?>
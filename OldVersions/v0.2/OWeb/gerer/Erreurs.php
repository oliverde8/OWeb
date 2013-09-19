<?php

namespace OWeb\Gerer;

require_once 'OWeb/Type/Erreur.php';

use OWeb\OWeb;
use OWeb\Type\Erreur as TErreur;

/**
 *
 * @author oliver De Cramer
 */
class Erreur {
    const NOTIFICATION = 'OWEB_ERR_N';
    const WARNING = 'OWEB_ERR_W';
    const FATAL = 'OWEB_ERR_F';

    private $erreures = array();
    private $nbErreur = 0;
    private $critic = false;
    private $debug = true;


    public function gestion_Erreur($no_erreur, $text_erreur, $fichier_erreur, $ligne_erreur) {

        $this->erreures[$this->nbErreur] = new TErreur($no_erreur, $text_erreur, $fichier_erreur, $ligne_erreur);
        $this->nbErreur++;

        $this->critic = true;

        if ($this->debug) {
            $this->afficher_Erreur($this->erreures[($this->nbErreur - 1)]);
        } else {
            $this->Erreur_mode();
        }
    }

    public function gestion_Exception($exception) { // these are our templates
        $traceline = "#%s %s(%s): %s(%s)";
        $msg = "PHP Fatal error:  Uncaught exception '%s' with message '%s' in %s:%s\nStack trace:\n%s\n  thrown in %s on line %s";

        // alter your trace as you please, here
        $trace = $exception->getTrace();
        foreach ($trace as $key => $stackPoint) {
            // I'm converting arguments to their type
            // (prevents passwords from ever getting logged as anything other than 'string')
            $trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
        }

        // build your tracelines
        $result = array();
        foreach ($trace as $key => $stackPoint) {
            $result[] = sprintf(
                            $traceline,
                            $key,
                            $stackPoint['file'],
                            $stackPoint['line'],
                            $stackPoint['function'],
                            implode(', ', $stackPoint['args'],"<br/>")
            );
        }
        // trace always ends with {main}
        $result[] = '#' . ++$key . ' {main}';

        // write tracelines into main template
        $msg = sprintf(
                        $msg,
                        get_class($exception),
                        $exception->getMessage(),
                        $exception->getFile(),
                        $exception->getLine(),
                        implode("\n", $result),
                        $exception->getFile(),
                        $exception->getLine()
        );

        // log or echo as you please
        echo $msg;
    }

    public function set_Debug($debug) {
        $this->debug = $debug;
    }

    private function afficher_Erreur(TErreur $erreur) {
        if (!(error_reporting() & $erreur->get_noErreur())) {
            // This error code is not included in error_reporting
            return;
        }

        switch ($erreur->get_noErreur()) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";
                echo "  Fatal error on line " . $erreur->get_nligneErreur() . " in file " . $erreur->get_fichierErreur();
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                break;

            case E_USER_WARNING:
                echo "<b>My WARNING</b> [" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>My NOTICE</b>[" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";
                break;

            case TErreur::FATAL:
                echo "<b>OWeb FATAL</b>[" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";

            case TErreur::WARNING:
                echo "<b>OWeb WARNING</b>[" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";

            case TErreur::NOTIFICATION:
                echo "<b>OWeb NOTIFICATION</b>[" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";

            default:
                if( $erreur->get_noErreur() == 8 && $erreur->get_textErreur()=="Undefined variable: string")break;
                echo "Unknown error type: [" . $erreur->get_noErreur() . "] " . $erreur->get_textErreur() . "<br />\n";
                break;
        }
        /* Don't execute PHP internal error handler */
        return true;
    }

    private function Erreur_mode() {
        /**
         * @todo Redirection en cas d'erreur
         */
    }

}

?>

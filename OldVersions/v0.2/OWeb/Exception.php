<?php

namespace OWeb;

/**
 * Une exception
 *
 * @package OWeb main
 * @author Oliver De Cramer
 */
class Exception extends \Exception{

    private $precedant = null;


    public function __construct($msg = '', $code = 0, Exception $precedant = null)
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            parent::__construct($msg, (int) $code);
            $this->precedant = $precedant;
        } else {
            parent::__construct($msg, (int) $code, $previous);
        }
    }

    /**
     * Permet de recuperer un string
     *
     * @return string
     */
    public function __toString()
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            if (null !== ($e = $this->getPrevious())) {
                return $e->__toString() 
                       . "\n\nNext "
                       . parent::__toString();
            }
        }
        return parent::__toString();
    }

    /**
     * Retourne l'exception precendante
     *
     * @return Exception|null
     */
    protected function _getPrevious()
    {
        return $this->_previous;
    }
}
?>

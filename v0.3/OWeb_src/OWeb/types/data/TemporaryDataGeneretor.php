<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oliverde8
 * Date: 29/09/13
 * Time: 11:34
 * To change this template use File | Settings | File Templates.
 */

namespace OWeb\types\data;

use OWeb\types\Configurable;

/**
 *
 *
 * Class TemporaryDataGeneretor
 * @package OWeb\types\data
 * @author De Cramer Oliver
 */
interface TemporaryDataGeneretor extends Configurable{

    public function getTemporaryData();

}
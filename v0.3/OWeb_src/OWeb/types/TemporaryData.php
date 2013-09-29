<?php

namespace OWeb\types;


use OWeb\types\data\Data;
use OWeb\types\data\TemporaryDataGeneretor;

/**
 * Creates a temporary data file that can be automatically updated if necessary.
 *
 * @TODO Should try to make it compatible with the TaskManager to be able to do the Update of the file in background if necessary
 *
 * Class TemporaryData
 * @package OWeb\types
 * @author oliverde8
 */
class TemporaryData extends Data
{


    const RESET_NEVER = -1;
    const RESET_ALWAYS = 0;

    private $upToDate = false;
    private $resetTime = 0;

    private $class;
    private $params = array();
    private $lastUpdate = 0;

    function __construct($dataCategory, $dataId, $fileName = null)
    {
        parent::__construct($dataCategory, $dataId, $fileName);

        if (file_exists($this->getFile() . '.odata')) {
            $this->loadData();

            if (($this->resetTime != self::RESET_NEVER && time() - $this->lastUpdate > $this->resetTime)
                || $this->resetTime == self::RESET_ALWAYS
            ) {
                $data = $this->generateData();
                $this->saveData($data);
            }
        }
    }

    private function loadData()
    {
        $data = simplexml_load_file($this->getFile() . '.odata');

        $this->class = is_string($data->class) ? $data->class : "";
        $this->resetTime = (int)$data->resetInstruction;
        $this->lastUpdate = (int)$data->lastUpdate;

        if (is_array($this->data->params->param)) {
            foreach ($this->data->params->param as $param) {
                $this->params[$param['name']] = $param['value'];
            }
        }
    }

    public function generateData()
    {
        $obj = new $this->class();
        if ($obj instanceof TemporaryDataGeneretor) {
            foreach ($this->params as $name => $val) {
                $obj->addParams($name, $val);
            }
            return $obj->getTemporaryData();
        }
        return null;
    }

    public function saveData($data)
    {
        parent::saveData($data);
        $this->updated();
    }

    public function updated()
    {
        $this->lastUpdate = time();
        $this->saveInfoData();
        $this->upToDate = true;
    }

    private function saveInfoData()
    {

        $xml = '
            <TempData>
                <resetInstruction>' . $this->resetTime . '</resetInstruction>
                <class>' . $this->class . '</class>
                <params>';

        foreach ($this->params as $name => $val) {
            $xml .= '            <param name="' . $name . '" value="' . $val . '"/>';
        }

        $xml .= '        </params>
                <lastUpdate>' . $this->lastUpdate . '</lastUpdate>
             </TempData>
        ';

        $this->data = simplexml_load_string($xml);
    }

    public function isUpToDate()
    {
        return $this->upToDate;
    }

    public function setUpdateClass($className)
    {
        $this->class = $className;
    }

    public function getUpdateClass()
    {
        return $this->class;
    }

    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function addParam($paramName, $value)
    {
        $this->params[$paramName] = $value;
    }
}
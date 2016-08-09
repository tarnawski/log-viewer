<?php

namespace LogViewerBundle\Reader;

class LogCommutator
{
    /** @var  array */
    private $logsConf;

    public function __construct($logsConf)
    {
        $this->logsConf = $logsConf;
    }

    public function getConfiguration($name)
    {
        if ($name == 'default') {
            return reset($this->logsConf);
        }
        if (!isset($this->logsConf[$name])) {
            return false;
        }

        return $this->logsConf[$name];
    }
}

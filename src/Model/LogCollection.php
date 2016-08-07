<?php

namespace LogViewerBundle\Model;

class LogCollection
{
    /** @var array */
    private $logs;

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param Log
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;
    }

    public function filterLogs(LogCriteria $criteria){

        $filtered = $this->logs;
        if($criteria->level){
            $filtered = array_filter($filtered, function($log) use ($criteria){
                return $log->getLevel() == $criteria->level ? true : false;
            });
        }
        if($criteria->date){
            $filtered = array_filter($filtered, function($log) use ($criteria){
                return $log->getDateTime() >= $criteria->date ? true : false;
            });
        }
        if($criteria->message){
            $filtered = array_filter($filtered, function($log) use ($criteria){
                return (strpos($log->getMessage(), $criteria->message) !== false) ? true : false;
            });
        }
        if($criteria->limit){
            $filtered = array_slice($filtered, 0, $criteria->limit);
        }

        return $filtered;
    }
}
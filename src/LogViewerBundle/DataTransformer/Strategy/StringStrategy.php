<?php

namespace LogViewerBundle\DataTransformer\Strategy;

use LogViewerBundle\DataTransformer\TransformStrategy;
use LogViewerBundle\Model\Log;
use LogViewerBundle\Model\LogCollection;

class StringStrategy implements TransformStrategy
{
    public function transform(array $data)
    {
        $logs = new LogCollection();
        foreach ($data as $line) {
            preg_match("/\[(?P<timestamp>.*)\] (?P<logger>\w+).(?P<level>\w+): (?P<message>[^\[\{]+) (?P<context>[\[\{].*[\]\}]) (?P<extra>[\[\{].*[\]\}])/", $line, $log);
            if ($log) {
                $logObj = new Log(
                    $log['message'],
                    $log['context'],
                    $log['level'],
                    $log['logger'],
                    new \DateTime($log['timestamp'])
                );
                $logs->addLog($logObj);
            }
        }

        return $logs;
    }
}

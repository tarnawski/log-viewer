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
                    isset($log['message']) ? $log['message'] : null,
                    isset($log['context']) ? $log['context'] : null,
                    isset($log['level']) ? $log['level'] : null,
                    isset($log['logger']) ? $log['logger'] : null,
                    isset($log['timestamp']) ? new \DateTime($log['timestamp']) : null
                );
                $logs->addLog($logObj);
            }
        }

        return $logs;
    }
}

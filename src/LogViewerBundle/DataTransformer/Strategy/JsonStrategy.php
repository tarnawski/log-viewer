<?php

namespace LogViewerBundle\DataTransformer\Strategy;

use LogViewerBundle\DataTransformer\TransformStrategy;
use LogViewerBundle\Model\Log;
use LogViewerBundle\Model\LogCollection;

class JsonStrategy implements TransformStrategy
{
    public function transform(array $data)
    {
        $logs = new LogCollection();
        foreach ($data as $line) {
            $log = json_decode($line, true);
            if ($log) {
                $logObj = new Log(
                    $log['message'],
                    $log['context'],
                    $log['level_name'],
                    $log['channel'],
                    new \DateTime($log['datetime']['date'])
                );
                $logs->addLog($logObj);
            }
        }

        return $logs;
    }
}

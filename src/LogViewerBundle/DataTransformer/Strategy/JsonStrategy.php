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
                    isset($log['message']) ? $log['message'] : null,
                    isset($log['context']) ? $log['context'] : null,
                    isset($log['level_name']) ? $log['level_name'] : null,
                    isset($log['channel']) ? $log['channel'] : null,
                    isset($log['datetime']['date']) ? new \DateTime($log['datetime']['date']) : null
                );
                $logs->addLog($logObj);
            }
        }

        return $logs;
    }
}

<?php

namespace App\Libraries;

class LogParser
{
    protected $logFile;

    public function __construct($logFile)
    {
        $this->logFile = $logFile;
    }

    public function getActiveProviders($timeThreshold = 1200)
    {
        $activeProviders = [];
        $currentTime = time();
        $handle = fopen($this->logFile, "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'PROVIDER_ACTIVITY') !== false) {
                    preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}).*ID: (\d+).*ACTION: (\w+).*DURATION: ([\d.]+).*RESULT: (\w+)/', $line, $matches);
                    if (count($matches) === 6) {
                        $timestamp = strtotime($matches[1]);
                        if ($currentTime - $timestamp <= $timeThreshold) {
                            $providerId = $matches[2];
                            $action = $matches[3];
                            $duration = $matches[4];
                            $result = $matches[5];

                            if (!isset($activeProviders[$providerId])) {
                                $activeProviders[$providerId] = [
                                    'id' => $providerId,
                                    'last_activity' => date('Y-m-d H:i:s', $timestamp),
                                    'actions' => []
                                ];
                            }
                            $activeProviders[$providerId]['actions'][] = [
                                'action' => $action,
                                'duration' => $duration,
                                'result' => $result,
                                'timestamp' => date('Y-m-d H:i:s', $timestamp)
                            ];
                        }
                    }
                }
            }
            fclose($handle);
        }

        return array_values($activeProviders);
    }
}

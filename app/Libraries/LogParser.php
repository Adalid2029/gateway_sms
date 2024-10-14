<?php

namespace App\Libraries;

class LogParser
{
    protected $logFile;

    public function __construct($logFile)
    {
        $this->logFile = $logFile;
    }

    public function getActiveProviders($timeThreshold = 5)
    {
        $activeProviders = [];
        $currentTime = time();
        $handle = fopen($this->logFile, "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'PROVIDER_ACTIVITY') !== false) {
                    preg_match('/ID: (\d+).*ACTION: (\w+).*END.*DURATION: ([\d.]+).*RESULT: (\w+)/', $line, $matches);
                    if (count($matches) === 5) {
                        $timestamp = strtotime(substr($line, 0, 19));
                        if ($currentTime - $timestamp <= $timeThreshold) {
                            $providerId = $matches[1];
                            $action = $matches[2];
                            $duration = $matches[3];
                            $result = $matches[4];

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
                                'result' => $result
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

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
                    // Extraer la fecha y hora del log
                    preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $line, $dateMatches);
                    if (empty($dateMatches)) {
                        continue;  // Skip this line if we can't extract the date
                    }
                    $timestamp = strtotime($dateMatches[1]);

                    // Extraer los detalles de la actividad
                    preg_match('/ID: (\d+).*ACTION: (\w+).*DURATION: ([\d.]+).*RESULT: (\w+)/', $line, $matches);
                    if (count($matches) === 5) {
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

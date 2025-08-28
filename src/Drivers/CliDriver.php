<?php

namespace Telemetry\Drivers;

class CliDriver implements DriverInterface
{
    /**
     * Summary of log
     * 
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log(string $level, string $message, array $context = []): void
    {
        $time = date('Y-m-d H:i:s');
        
        echo "[$time] {$level}: $message " . json_encode($context) . "\n";
    }
}
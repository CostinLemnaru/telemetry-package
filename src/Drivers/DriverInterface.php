<?php
namespace Telemetry\Drivers;

use Telemetry\LogLevel;

interface DriverInterface {
    const DEBUG = 'debug';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    const LEVELS = [
        self::DEBUG,
        self::INFO,
        self::WARNING,
        self::ERROR
    ];
    
    public function log(string $level, string $message, array $tags = []): void;
}

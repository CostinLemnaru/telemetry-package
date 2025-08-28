<?php
namespace Telemetry;

use Telemetry\Drivers\DriverInterface;

class Logger {
    
    /** @var DriverInterface[] */
    private array $drivers = [];

    public function __construct(array $drivers) {
        $this->drivers = $drivers;
    }

    /**
     * Write log.
     * 
     * @param string $level
     * @param string $message
     * @param array $tags
     * @return void
     */
    public function log(string $level, string $message, array $tags = []): void
    {
        foreach ($this->drivers as $driver) {
            $driver->log($level, $message, $tags);
        }
    }

    /**
     * Write debug log.
     * 
     * @param string $message
     * @param array $tags
     * @return void
     */
    public function debug(string $message, array $tags = []): void
    {
        $this->log(DriverInterface::DEBUG, $message, $tags);
    }

    /**
     * Write warning log.
     * 
     * @param string $message
     * @param array $tags
     * @return void
     */
    public function warning(string $message, array $tags = []): void
    {
        $this->log(DriverInterface::WARNING, $message, $tags);
    }

    /**
     * Write info log.
     * 
     * @param string $message
     * @param array $tags
     * @return void
     */
    public function info(string $message, array $tags = []): void
    {
        $this->log(DriverInterface::INFO, $message, $tags);
    }

    /**
     * Write error log.
     * 
     * @param string $message
     * @param array $tags
     * @return void
     */
    public function error(string $message, array $tags = []): void 
    {
        $this->log(DriverInterface::ERROR, $message, $tags);
    }
}

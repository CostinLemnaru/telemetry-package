<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Telemetry\Logger;
use Telemetry\Drivers\CliDriver;
use Telemetry\Drivers\DriverInterface;

class LoggerTest extends TestCase {
    public function testCliDriver() 
    {
        $cliDriver = new CliDriver();
        $logger = new Logger([$cliDriver]);

        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];

        $this->expectOutputString("Testing CLI Driver.");


        $this->expectOutputRegex('/'.DriverInterface::INFO.': Testing CLI Driver/');
        $this->expectOutputRegex('/"id":100320/');

        $logger->info("testing cli driver", $tags);

    }
}
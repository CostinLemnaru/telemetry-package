<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Telemetry\Logger;
use Telemetry\Drivers\CliDriver;
use Telemetry\Drivers\DriverInterface;

class LoggerTest extends TestCase {

    public function testInfo()
    {
        $cliDriver = new CliDriver();
        $logger = new Logger([$cliDriver]);
        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];

        $this->expectOutputRegex('/'.DriverInterface::INFO.': Testing CLI Driver/');
        $this->expectOutputRegex('/"id":100320/');
        $this->expectOutputRegex('/"source":"api"/');

        $logger->info("Testing CLI Driver", $tags);
    }

    public function testDebug()
    {
        $cliDriver = new CliDriver();
        $logger = new Logger([$cliDriver]);
        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];

        $this->expectOutputRegex('/'.DriverInterface::DEBUG.': Debug message/');
        $this->expectOutputRegex('/"id":100320/');
        $this->expectOutputRegex('/"source":"api"/');

        $logger->debug("Debug message", $tags);
    }

    public function testWarning()
    {
        $cliDriver = new CliDriver();
        $logger = new Logger([$cliDriver]);
        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];

        $this->expectOutputRegex('/'.DriverInterface::WARNING.': Some warn logged/');
        $this->expectOutputRegex('/"id":100320/');
        $this->expectOutputRegex('/"source":"api"/');

        $logger->warning("Some warn logged", $tags);
    }

    public function testError()
    {
        $cliDriver = new CliDriver();
        $logger = new Logger([$cliDriver]);
        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];

        $this->expectOutputRegex('/'.DriverInterface::ERROR.': server error/');
        $this->expectOutputRegex('/"id":100320/');
        $this->expectOutputRegex('/"source":"api"/');

        $logger->error("server error", $tags);
    }
}
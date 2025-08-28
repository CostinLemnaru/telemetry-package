<?php

namespace Tests;

use Telemetry\Logger;
use PHPUnit\Framework\TestCase;
use Telemetry\Drivers\CliDriver;
use Telemetry\Drivers\JsonFileDriver;
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

    public function testWritesLogToJsonFile()
    {
        $file = __DIR__ . '/JsonFIleDriverLogs.json';

        $jsonDriver = new JsonFileDriver($file);

        $logger = new Logger([$jsonDriver]);

        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];
        $logger->info('Testing JSON Driver', $tags);

        $this->assertFileExists($file);

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->assertNotEmpty($lines, 'Fișierul ar trebui să conțină cel puțin o linie.');
        $lastLog = json_decode(array_pop($lines), true);

        $this->assertSame(DriverInterface::INFO, $lastLog['level']);
        $this->assertSame('Testing JSON Driver', $lastLog['message']);
        $this->assertSame($tags, $lastLog['tags']);
        $this->assertNotEmpty($lastLog['timestamp']);
    }
}
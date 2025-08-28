<?php

namespace Tests;

use Telemetry\Logger;
use PHPUnit\Framework\TestCase;
use Telemetry\Drivers\CliDriver;
use Telemetry\Drivers\JsonFileDriver;
use Telemetry\Drivers\TextFileDriver;
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

    public function testJsonFileDriver()
    {
        $file = __DIR__ . '/JsonFIleDriverLogs.json';
        file_put_contents($file, '');

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

    public function testTextFileDriver()
    {
        $file = __DIR__ . '/TextFileDriver.log';
        file_put_contents($file, '');

        $textDriver = new TextFileDriver($file);
        $logger = new Logger([$textDriver]);

        $tags = [
            'id' => 100320,
            'source' => 'api'
        ];
        $logger->info('Testing Text Driver', $tags);

        $this->assertFileExists($file);

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lastLine = array_pop($lines);

        $this->assertStringContainsString(DriverInterface::INFO.': Testing Text Driver', $lastLine);
        $this->assertStringContainsString('"id":100320', $lastLine);
        $this->assertStringContainsString('"source":"api"', $lastLine);
    }

    public function testMultipleDrivers()
    {
        $jsonFile = __DIR__ . '/JsonFIleDriverLogs.json';
        $textFile = __DIR__ . '/TextFileDriver.log';

        file_put_contents($jsonFile, '');
        file_put_contents($textFile, '');

        $drivers = [
            new CliDriver(),
            new JsonFileDriver($jsonFile),
            new TextFileDriver($textFile),
        ];

        $logger = new Logger($drivers);

        // Cli Driver
        $this->expectOutputRegex('/Multidriver message/');

        $logger->info('Multidriver message');

        // JSON FILE Driver
        $this->assertFileExists($jsonFile);
        $jsonLines = file($jsonFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lastJson = json_decode(array_pop($jsonLines), true);
        $this->assertSame('Multidriver message', $lastJson['message'] ?? null);

        // TEXT FILE Driver
        $this->assertFileExists($textFile);
        $textLines = file($textFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lastText = array_pop($textLines);
        $this->assertStringContainsString('Multidriver message', $lastText);
    }
}
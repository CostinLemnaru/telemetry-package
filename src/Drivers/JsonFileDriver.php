<?php
namespace Telemetry\Drivers;

class JsonFileDriver implements DriverInterface {
    private string $file;

    public function __construct(string $file) {
        $this->file = $file;
    }

    public function log(string $level, string $message, array $tags = []): void {
        $log = [
            'timestamp' => date_create(),
            'level' => $level,
            'message' => $message,
            'tags' => $tags,
        ];

        file_put_contents(
            $this->file,
            json_encode($log) . PHP_EOL,
            FILE_APPEND
        );
    }
}

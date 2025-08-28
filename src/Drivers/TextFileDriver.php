<?php

namespace Telemetry\Drivers;

class TextFileDriver implements DriverInterface {
    private string $file;

    public function __construct(string $file) {
        $this->file = $file;
    }

    public function log(string $level, string $message, array $tags = []): void {
        $time = date('Y-m-d H:i:s');
        $line = sprintf(
            "[%s] %s: %s %s",
            $time,
            $level,
            $message,
            json_encode($tags, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        file_put_contents($this->file, $line . PHP_EOL, FILE_APPEND);
    }
}

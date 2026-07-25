<?php

namespace Delta\Components\Env;

use RuntimeException;

use Delta\Components\Env\interfaces\DotEnvironment as IDotEnvironment;

final class DotEnvironment implements IDotEnvironment
{
    private const REGEX_PATTERN = "/\s*=\s*/";

    public function load(string $path): void
    {
        $file = $path;

        if (!file_exists($file)) {
            throw new RuntimeException("Dotenv file not exist: {$file}");
        }

        $lines = file($file);

        if (empty($lines)) return;

        foreach ($lines as $line) {
            if (!preg_match(self::REGEX_PATTERN, $line)) continue;

            [$key, $value] = explode("=", $line);

            $key = trim($key);

            $value = trim($value);

            $this->setSystemVariable($key, $value);

            $this->setGlobalVariable($key, $value);
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return $_ENV[$key] ?? $default;
    }

    private function setSystemVariable(string $key, string $value): void
    {
        $assignment = sprintf("%s=%s", $key, $value);

        putenv($assignment);
    }

    private function setGlobalVariable(string $key, string $value): void
    {
        $_ENV[$key] = $value;
    }
}

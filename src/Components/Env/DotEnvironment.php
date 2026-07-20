<?php

namespace Delta\Components\Env;

use RuntimeException;

use Delta\Components\Env\interfaces\DotEnvEnvironment as IDotEnvEnvironment;

final class DotEnvEnvironment implements IDotEnvEnvironment
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

    public static function get(
        string $key,
        ?string $defaultValue = null,
    ): ?string {
        return $_ENV[$key] ?? $defaultValue;
    }

    private function setSystemVariable(string $key, string $value): void
    {
        $assignment = sprintf("%s=%s", $key, $value);

        putenv($assignment);
    }

    /**
     * Possible in $_ENV
     */
    private function setGlobalVariable(string $key, string $value): void
    {
        $_ENV[$key] = $value;
    }
}

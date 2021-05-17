<?php
/** @author Freezemage <freezemage0@gmail.com> */


namespace Freezemage\Environment;


use RuntimeException;
use function array_key_exists;
use function fclose;
use function feof;
use function fgets;
use function fopen;
use function getenv;
use function is_file;
use function is_readable;
use function putenv;
use function sprintf;
use function str_replace;
use function trim;


final class Environment {
    public static function fromFile(string $filename): Environment {
        if (!is_file($filename) || !is_readable($filename)) {
            throw MissingFileException::create('Environment file not found or is not accessible.');
        }

        $f = fopen($filename, 'r');
        $env = new Environment();

        while (!feof($f)) {
            $line = trim(fgets($f));
            list($name, $value) = explode('=', $line);
            $value = str_replace('"', '', $value);
            $env->set($name, $value);
        }

        fclose($f);
        return $env;
    }

    public function has(string $key): bool {
        return array_key_exists($key, $this->getAll());
    }

    public function get(string $key, $defaultValue = null) {
        $env = $this->getAll();
        return $env[$key] ?? $defaultValue;
    }

    public function getAll(): array {
        return getenv();
    }

    public function set(string $key, $value = null): Environment {
        if (empty($value)) {
            $value = 0;
        }

        putenv(sprintf('%s=%s', $key, $value));
        return $this;
    }
}
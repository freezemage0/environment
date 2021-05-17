<?php
/** @author Freezemage <freezemage0@gmail.com> */


namespace Freezemage\Environment;

use Exception;


class MissingFileException extends Exception {
    public static function create(string $filename): MissingFileException {
        return new MissingFileException(sprintf('File %s does not exist or is not readable.', $filename));
    }
}
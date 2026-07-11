<?php
class MyException extends Exception {

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        $completedMsg = (substr($message, -1) === PHP_EOL ? $message : $message . PHP_EOL)
                . "Exception triggered at line " . $this->getLine()
                . " in file " . $this->getFile() . PHP_EOL
                . "WARNING: File will not be created\n";
        parent::__construct($completedMsg, $code, $previous);
    }

}

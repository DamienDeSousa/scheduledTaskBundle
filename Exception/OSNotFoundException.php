<?php

namespace Dades\ScheduledTaskBundle\Exception;

/**
 * To throw when the operating system is not found
 *
 * @author Damien DE SOUSA
 */
class OSNotFoundException extends \Exception
{
    /**
     * @param string $message [description]
     * @param int    $code    [description]
     * @param string $file    [description]
     * @param int    $line    [description]
     */
    public function __construct(string $message, int $code, string $file, int $line)
    {
        parent::__construct($message, $code);
        $this->file = $file;
        $this->line = $line;
    }

    /**
     * Return an explicit message of the error
     * @return [type] [description]
     */
    public function getExplicitMessage()
    {
        return $this->getMessage()." in ".$this->getFile()." at line ".$this->getLine().PHP_EOL.$this->getTraceAsString().PHP_EOL;
    }
}

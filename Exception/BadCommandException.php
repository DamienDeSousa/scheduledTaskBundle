<?php

namespace Dades\ScheduledTaskBundle\Exception;

/**
 * To throw when a command get an error
 *
 * @author Damien DE SOUSA
 */
class BadCommandException extends \Exception
{
    /**
     * the command that is on error
     * @var string
     */
    protected $command;

    /**
     * @param string $command [description]
     * @param string $message [description]
     * @param int    $code    [description]
     * @param string $file    [description]
     * @param int    $line    [description]
     */
    public function __construct(string $command, string $message, int $code, string $file, int $line)
    {
        $this->command = $command;
        $this->message = $message;
        $this->code = $code;
        $this->file = $file;
        $this->line = $line;
    }

    /**
     * Return an explicit message of the error
     * @return string [description]
     */
    public function getExplicitMessage()
    {
        return "The command [$this->command] failed: $this->message in $this->file at line $this->line".PHP_EOL.$this->getTraceAsString().PHP_EOL;
    }
}

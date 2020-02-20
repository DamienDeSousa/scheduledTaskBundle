<?php
/**
 * Exception when a command gets an error
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2019
 */
namespace Dades\ScheduledTaskBundle\Exception;

/**
 * BadCommandException class.
 */
class BadCommandException extends \Exception
{
    /**
     * the command that is on error.
     *
     * @var string
     */
    protected $command;

    /**
     * Constructor.
     *
     * @param string $command
     * @param string $message
     * @param int    $code
     * @param string $file
     * @param int    $line
     */
    public function __construct(string $command, string $message, int $code, string $file, int $line)
    {
        parent::__construct($message, $code);
        $this->command = $command;
        $this->file = $file;
        $this->line = $line;
    }

    /**
     * Return an explicit message of the error
     *
     * @return string
     */
    public function getExplicitMessage()
    {
        return 'The command [' . $this->command . '] failed: ' . $this->message . 'in $this->file at line $this->line' .
        PHP_EOL . $this->getTraceAsString() . PHP_EOL;
    }
}

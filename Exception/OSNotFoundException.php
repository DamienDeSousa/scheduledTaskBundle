<?php
/**
 * Exception used when OS is not found
 *
 * @author Damien DE SOUSA <de.sousa.damien.prod@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Exception;

/**
 * OSNotFoundException class
 */
class OSNotFoundException extends \Exception
{
    /**
     * Constructor
     *
     * @param string $message
     * @param int    $code
     * @param string $file
     * @param int    $line
     */
    public function __construct(string $message, int $code, string $file, int $line)
    {
        parent::__construct($message, $code);
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
        return $this->getMessage().' in '.$this->getFile().' at line '.$this->getLine().PHP_EOL.$this->getTraceAsString().PHP_EOL;
    }
}

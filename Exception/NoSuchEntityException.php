<?php
/**
 * Exception when an entity is nt found
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Exception;

/**
 * NoSuchEntityException class
 */
class NoSuchEntityException extends \Exception
{
    /**
     * Constructor
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    /**
     * Return an explicit message of the error
     *
     * @return string
     */
    public function getExplicitMessage()
    {
        $message = $this->message;
        $message .= 'Stack trace:'.PHP_EOL;
        $message .= $this->getTraceAsString().PHP_EOL;

        return $message;
    }
}

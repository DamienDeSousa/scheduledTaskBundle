<?php

namespace Dades\ScheduledTaskBundle\Exception;

/**
 * To throw when an entity is nt found
 *
 * @author Damien DE SOUSA
 */
class NoSuchEntityException extends \Exception
{
    /**
     * @param string $message [description]
     * @param int    $code    [description]
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    /**
     * Return an explicit message of the error
     * @return string [description]
     */
    public function getExplicitMessage()
    {
        $message = $this->message;
        $message .= "Stack trace:".PHP_EOL;
        $message .= $this->getTraceAsString().PHP_EOL;

        return $message;
    }
}

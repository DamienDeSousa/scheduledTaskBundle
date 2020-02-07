<?php
/**
 * Log messages in var/logs/dades_scheduled_task_bundle.log.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 */
namespace Dades\ScheduledTaskBundle\Service;

use InvalidArgumentException;

/**
 * Logger class.
 */
class Logger
{
    /**
     * The file in which the logs will be written.
     *
     * @var string
     */
    protected $fileLog;

    /**
     * The path where the log file is.
     *
     * @var string
     */
    protected $projectDirectory;

    /**
     * The full path, the project dir plus the file name.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructor.
     *
     * @param string $projectDirectory
     * @param string $fileLog
     */
    public function __construct(string $projectDirectory, string $fileLog)
    {
        $this->projectDirectory = $projectDirectory;
        $this->fileLog = $fileLog;
        $this->path = $this->projectDirectory . DIRECTORY_SEPARATOR . 'var' .
        DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $this->fileLog;

        if (!file_exists($this->path)) {
            file_put_contents($this->path, '');
        }
    }

    /**
     * Write log with the status code and the message to write.
     *
     * @param  int          $status
     * @param  array|string $output
     */
    public function writeLog(int $status, $output)
    {
        if (!is_array($output) && !is_string($output)) {
            throw new InvalidArgumentException(
                'The $output parameter must be string or array, ' . gettype($output) . ' given.'
            );
        }
        $message = '';
        if (is_array($output)) {
            $message = $this->stringifyOutput($output);
        } elseif (is_string($output)) {
            $message = $output;
        }

        file_put_contents(
            $this->path,
            '[' . $this->getDate() . ']: ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }

    /**
     * Transform an array to a string
     *
     * @param  array  $output
     *
     * @return string
     */
    protected function stringifyOutput(array $output): string
    {
        $result = '';
        foreach ($output as $key => $value) {
            $result .= $value . PHP_EOL;
        }
        return $result;
    }

    /**
     * Get the current date
     *
     * @return string
     */
    protected function getDate(): string
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Get the current file log
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->fileLog;
    }
}

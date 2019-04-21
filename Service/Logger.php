<?php

namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Service\Utility\FolderSeparator;

/**
 * Log messages in var/logs/dades_scheduled_task_bundle.log
 * @author Damien DE SOUSA
 */
class Logger
{
    /**
     * The file in which the logs will be written
     * @var string
     */
    protected $fileLog;

    /**
     * The path where the log file is
     * @var string
     */
    protected $projectdir;

    /**
     * The full path, the project dir plus the file name
     * @var string
     */
    protected $path;

    protected $folderSeparator;

    /**
     * [__construct description]
     * @param string $rootDir [description]
     */
    public function __construct(string $projectdir, string $fileLog)
    {
        $this->projectdir = $projectdir;
        $this->fileLog = $fileLog;
        $this->folderSeparator = FolderSeparator::getSeparator();
        $this->path = $this->projectdir.$this->folderSeparator.'var'.$this->folderSeparator.'logs'.$this->folderSeparator.$this->fileLog;

        if (!file_exists($this->path)) {
            file_put_contents($this->path, "");
        }
    }

    /**
     * Write log with the status code and the message to write
     * @param  int    $status [description]
     * @param  array|string $output [description]
     */
    public function writeLog(int $status, $output)
    {
        $message = "";
        if (is_array($output)) {
            $message = $this->stringifyOutput($output);
        } elseif (is_string($output)) {
            $message = $output;
        }

        file_put_contents(
            $this->path,
            "[".$this->getDate()."]: ".$message.PHP_EOL,
            FILE_APPEND
        );
    }

    /**
     * Transforme an array to a string
     * @param  array  $output [description]
     * @return string         [description]
     */
    public function stringifyOutput(array $output): string
    {
        $result = "";
        foreach ($output as $key => $value) {
            $result .= $value.PHP_EOL;
        }
        return $result;
    }

    /**
     * Get the current date
     * @return [type] [description]
     */
    protected function getDate()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Get the current file
     * @return string [description]
     */
    public function getFile()
    {
        return $this->fileLog;
    }
}

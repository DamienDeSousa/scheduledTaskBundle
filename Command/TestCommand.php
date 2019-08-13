<?php

/**
 * Run all defined cron in Symfony.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * RunCronCommand class
 */
class TestCommand extends Command
{
    /**
     * Command that run all cron defined in this bundle
     *
     * @var string
     */
    protected static $defaultName = 'test:test';

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setDescription('Run all crons.')
            ->setHelp('Run all crons created in Symfony.')
            ->addOption('kkk', 'k', InputOption::VALUE_NONE, 'Test test test');
    }

    /**
     * The body of the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $option = $input->getOption('kkk');
        $output->writeln('[' . date('Y-m-d H:i:s') . ']: ');
        if ($option) {
            echo 'im in' . "\n";
        } else {
            echo 'im out' . "\n";
        }
    }
}

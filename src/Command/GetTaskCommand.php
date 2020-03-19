<?php


namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetTaskCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('app:get-task')->setDescription('Get Task About');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
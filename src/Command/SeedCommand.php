<?php

namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class SeedCommand extends AbstractCommand
{
    private $kernel;

    private $seeds = [
        [
            'command' => 'app:import:developer'
        ],
        [
            'command' => 'app:import:provider'
        ]
    ];

    /**
     * SeedCommand constructor.
     * @param ContainerInterface $container
     * @param KernelInterface $kernel
     * @param string|null $name
     */
    public function __construct(ContainerInterface $container, KernelInterface $kernel, ?string $name = null)
    {
        $this->kernel = $kernel;
        parent::__construct($container, $name);
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('app:seed')->setDescription('seeder');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        foreach ($this->seeds as $seed) {
            $output->writeln($seed['command'] . ' <fg=green>starting</>');
            $input = new ArrayInput(array(
                'command' => $seed['command']
            ));
            $application->run($input, $output);
            $output->writeln($seed['command'] . ' <fg=red>finished</>');
        }
    }
}
<?php


namespace App\Command\Import;

use App\Command\AbstractCommand;
use App\Entity\Developer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeveloperCommand extends AbstractCommand
{
    private $developers = [
        0 => [
            'name' => 'DEV1',
            'level' => 1
        ],
        1 => [
            'name' => 'DEV2',
            'level' => 2
        ],
        2 => [
            'name' => 'DEV3',
            'level' => 3
        ],
        3 => [
            'name' => 'DEV4',
            'level' => 4
        ],
        4 => [
            'name' => 'DEV5',
            'level' => 5
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setName('app:import:developer')->setDescription('Import Developer');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $developerCount = $this->entityManager->getRepository(Developer::class)->count([]);
        if ($developerCount === 0) {
            foreach ($this->developers as $developer) {
                $newDeveloper = new Developer();
                $newDeveloper->setName($developer['name']);
                $newDeveloper->setLevel($developer['level']);
                $this->entityManager->persist($newDeveloper);
            }

            $this->entityManager->flush();
        }
    }
}
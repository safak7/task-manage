<?php


namespace App\Command\Import;

use App\Command\AbstractCommand;
use App\Entity\Provider;
use Cocur\Slugify\Slugify;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProviderCommand extends AbstractCommand
{
    private $provider = [
        0 => [
            'name' => 'Provider 1',
            'url' => 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa'
        ],
        1 => [
            'name' => 'Provider 2',
            'url' => 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7'
        ]
    ];

    protected function configure()
    {
        parent::configure();
        $this->setName('app:import:provider')->setDescription('Import Provider');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providerCount = $this->entityManager->getRepository(Provider::class)->count([]);
        if ($providerCount === 0) {
            $slugify = new Slugify();
            foreach ($this->provider as $provider) {
                $newProvider = new Provider();
                $newProvider->setName($provider['name']);
                $newProvider->setSlug($slugify->slugify($provider['name']));
                $newProvider->setUrl($provider['url']);
                $this->entityManager->persist($newProvider);
            }
            $this->entityManager->flush();
        }
    }
}
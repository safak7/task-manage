<?php

namespace App\Command;

use App\Adapter\AdapterHandler;
use App\Entity\Provider;
use App\Helper\StringHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetTaskCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('app:task:get')->setDescription('Get Task Lists');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providers = $this->entityManager->getRepository(Provider::class)->findAll();
        foreach ($providers as $provider) {
            $provider->setSlug(str_replace('-', '', $provider->getSlug()));
            $provider->setSlug('Provider2');
            $providerAdaptorName = self::ADAPTERS_NAMESPACE . '\\'
                . StringHelper::className($provider->getSlug()) . 'Adapter';
            $adapter = new AdapterHandler((new $providerAdaptorName()));

            $taskList = $adapter->getTasks($provider->getUrl());
            $adapter->createTasks($provider->getId(), $taskList);

            $output->writeln($provider->getName() . ' tasks added to DB');
        }
    }
}
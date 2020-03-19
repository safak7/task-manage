<?php


namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    /** @var ContainerInterface $container */
    protected $container;

    /** @var \Doctrine\Persistence\ObjectManager */
    protected $entityManager;

    /**
     * ProductPushCommand constructor.
     * @param ContainerInterface $container
     * @param null|string $name
     */
    public function __construct(ContainerInterface $container, ?string $name = null)
    {
        $this->container = $container;
        $this->entityManager = $this->container->get('doctrine')->getManager();

        parent::__construct($name);
    }
}
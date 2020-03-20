<?php

namespace App\Subscriber;

use App\Adapter\AdapterAbstract;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ContainerSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ExceptionSubscriber constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => ['inject'],
            KernelEvents::REQUEST => ['inject'],
            ConsoleEvents::COMMAND => ['inject']
        );
    }

    /**
     *
     */
    public function inject()
    {
        AdapterAbstract::setContainer($this->container);
    }
}
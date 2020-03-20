<?php

namespace App\Traits;

use Psr\Container\ContainerInterface;

trait Container
{
    /**
     * @var ContainerInterface $container
     */
    protected static $container;

    /**
     * MongoBaseResource constructor.
     * @param ContainerInterface $container
     */
    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }
}
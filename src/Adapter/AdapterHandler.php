<?php

namespace App\Adapter;


class AdapterHandler
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * AdapterHandler constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getTasks(string $url): array
    {
        return $this->adapter->getTasks($url);
    }

    /**
     * @param int $providerId
     * @param array $params
     */
    public function createTasks(int $providerId, array $params): void
    {
        $this->adapter->createTasks($providerId, $params);
    }
}

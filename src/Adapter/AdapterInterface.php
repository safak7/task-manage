<?php

namespace App\Adapter;

interface AdapterInterface
{
    /**
     * @param string $url
     * @return array
     */
    public function getTasks(string $url): array;

    /**
     * @param int $providerId
     * @param array $params
     */
    public function createTasks(int $providerId, array $params): void;
}

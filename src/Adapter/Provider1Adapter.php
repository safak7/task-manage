<?php

namespace App\Adapter;

use App\Adapter\Provider1\Task;

class Provider1Adapter extends AdapterAbstract implements AdapterInterface
{
    /**
     * @param string $url
     * @return array
     */
    public function getTasks(string $url): array
    {
        $task = new Task();
        return $task->taskList($url);
    }

    /**
     * @param int $providerId
     * @param array $params
     */
    public function createTasks(int $providerId, array $params): void
    {
        $task = new Task();
        $task->createTasks($providerId, $params);
    }
}
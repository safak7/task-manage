<?php

namespace App\Adapter\Provider1;

use App\Entity\Task as TaskEntity;

class Task extends AbstractProvider1
{
    /**
     * @param string $url
     * @return array
     */
    public function taskList(string $url): array
    {
        $data = [
            'request' => [
                'method' => 'GET',
                'url' => $url
            ],
            'body' => []
        ];
        return $this->sendRequest($data);
    }

    /**
     * @param int $providerId
     * @param array $data
     */
    public function createTasks(int $providerId, array $data): void
    {
        foreach ($data as $task) {
            $newTask = new TaskEntity();
            $newTask->setTitle($task['id']);
            $newTask->setLevel($task['zorluk']);
            $newTask->setDuration($task['sure']);
            $newTask->setProviderId($providerId);
            $this->entityManager->persist($newTask);
        }

        $this->entityManager->flush();
    }
}
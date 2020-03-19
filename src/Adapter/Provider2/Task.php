<?php


namespace App\Adapter\Provider2;

use App\Entity\Task as TaskEntity;

class Task extends AbstractProvider2
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
            foreach ($task as $taskDetailKey => $taskDetail) {
                $newTask = new TaskEntity();
                $newTask->setTitle($taskDetailKey);
                $newTask->setLevel($taskDetail['level']);
                $newTask->setDuration($taskDetail['estimated_duration']);
                $newTask->setProviderId($providerId);
                $this->entityManager->persist($newTask);
            }
        }

        $this->entityManager->flush();
    }
}
<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Task;
use App\Helper\NumberHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    const WEEK_TOTAL_HOUR = 45;

    /**
     * @Route("/", name="task.list")
     * @return Response
     */
    public function index(): Response
    {
        $entityManager = $this->container->get('doctrine')->getManager();

        $developerRepository = $entityManager->getRepository(Developer::class);
        $developers = $developerRepository->findAll();

        $taskRepository = $entityManager->getRepository(Task::class);
        $tasks = $taskRepository->findAllTaskWithProvider();

        $totalTime = $taskRepository->getTotalTime();
        $optimizeDeveloperLevel = $this->calculateOptimizeDeveloperLevel($developers);
        $averageTime = $totalTime['total_time'] / $optimizeDeveloperLevel;

        return $this->render('task/index.html.twig', [
            'controllerName' => 'TaskController',
            'lists' => $this->matchTaskToDeveloper($developers, $tasks, $averageTime),
            'estimateTime' => NumberHelper::numberFormat($averageTime / self::WEEK_TOTAL_HOUR, 2)
        ]);
    }

    /**
     * @param array $developers
     * @param array $tasks
     * @param float $averageTime
     * @return array
     */
    private function matchTaskToDeveloper(array $developers, array $tasks, float $averageTime): array
    {
        $weekCount = ceil($averageTime / self::WEEK_TOTAL_HOUR);
        $developerTasks = [];
        for ($i = 0; $i < $weekCount; $i++) {
            /** @var Developer $developer */
            foreach ($developers as $developer) {
                $developerTime[$developer->getId()][] = $developer->getLevel() * $averageTime;
                $developerMaxTime = round($developer->getLevel() * $averageTime);
                $weeklyDeveloperTotalTime = 0;
                $developerTotalTime = 0;
                /** @var Task $task */
                foreach ($tasks as $taskKey => $task) {
                    if (($task['duration'] * $task['level']) + $developerTotalTime
                        <= self::WEEK_TOTAL_HOUR * $developer->getLevel()
                        && ($weeklyDeveloperTotalTime + ($task['duration'] * $task['level'])) < $developerMaxTime
                    ) {
                        $developerTasks[$i][$developer->getId()]['developer'] = $developer;
                        $developerTasks[$i][$developer->getId()]['tasks'][] = $task;
                        $developerTotalTime += $task['duration'] * $task['level'];
                        $weeklyDeveloperTotalTime += $task['duration'] * $task['level'];
                        unset($tasks[$taskKey]);
                    } else {
                        break;
                    }
                }
                $developerTime[$developer->getId()][] = $weeklyDeveloperTotalTime;
            }
        }

        return $developerTasks;
    }

    /**
     * @param array $developers
     * @return int
     */
    private function calculateOptimizeDeveloperLevel(array $developers): int
    {
        $optimizeDeveloperLevel = 0;
        /** @var Developer $developer */
        foreach ($developers as $developer) {
            $optimizeDeveloperLevel += $developer->getLevel();
        }

        return $optimizeDeveloperLevel;
    }
}

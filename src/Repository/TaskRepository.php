<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllTaskWithProvider()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT t.id, t.title, t.level, t.duration, p.id AS pid, p.name AS pname
                FROM task t LEFT JOIN provider p ON p.id = t.provider_id';
        $gtm = $conn->prepare($sql);
        $gtm->execute();
        return $gtm->fetchAll();
    }

    /**
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTotalTime()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT sum(duration*level) AS total_time FROM task';
        $gtm = $conn->prepare($sql);
        $gtm->execute();
        return $gtm->fetch();
    }
}

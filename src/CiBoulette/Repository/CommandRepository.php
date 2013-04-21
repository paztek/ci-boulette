<?php
namespace CiBoulette\Repository;

class CommandRepository extends BaseRepository
{
    /**
     * @return integer
     */
    public function findLastPositionForRepository(\CiBoulette\Model\Repository $repository)
    {
        $builder = $this->createQueryBuilder('c')
            ->select('max(c.position)')
            ->andWhere('c.repository = :repository')
            ->setParameter('repository', $repository);

        $query = $builder->getQuery();

        return $query->getSingleScalarResult();
    }
}
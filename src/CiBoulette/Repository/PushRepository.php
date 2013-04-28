<?php
namespace CiBoulette\Repository;

class PushRepository extends BaseRepository
{
    /**
     * @return integer
     */
    public function findAllOrdered()
    {
        $builder = $this->createQueryBuilder('p')
			->select('p, r, c, af, be')
			->leftJoin('p.repository', 'r')
			->leftJoin('p.commits', 'c')
			->leftJoin('p.before', 'be')
			->leftJoin('p.after', 'af')
			->addOrderBy('p.timestamp', 'DESC');

        $query = $builder->getQuery();

        return $query->execute();
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllWithExecutions()
    {
        $builder = $this->createQueryBuilder('p')
            ->select('p, e')
            ->leftJoin('p.executions', 'e');

        $query = $builder->getQuery();

        return $query->execute();
    }

    /**
     * @param  integer                         $id
     * @return \CiBoulette\Model\Push
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findWithExecutions($id)
    {
        $builder = $this->createQueryBuilder('p')
            ->select('p, e')
            ->andWhere('p.id = :id')
            ->leftJoin('p.executions', 'e')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        return $query->getSingleResult();
    }
}

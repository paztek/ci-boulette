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
			->select('p, c, af, be')
			->leftJoin('p.commits', 'c')
			->leftJoin('p.before', 'be')
			->leftJoin('p.after', 'af')
			->addOrderBy('p.timestamp', 'DESC');

        $query = $builder->getQuery();

        return $query->execute();
    }
}

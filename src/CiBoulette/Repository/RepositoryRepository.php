<?php
namespace CiBoulette\Repository;

class RepositoryRepository extends BaseRepository
{
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllWithCommands()
    {
        $builder = $this->createQueryBuilder('r')
            ->select('r, c')
            ->leftJoin('r.commands', 'c');

        $query = $builder->getQuery();

        return $query->execute();
    }

    /**
     * @param integer $id
     * @return \CiBoulette\Model\Repository
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findWithCommands($id)
    {
        $builder = $this->createQueryBuilder('r')
            ->select('r, c')
            ->andWhere('r.id = :id')
            ->leftJoin('r.commands', 'c')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        return $query->getSingleResult();
    }
}
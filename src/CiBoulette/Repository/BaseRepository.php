<?php
namespace CiBoulette\Repository;

use Doctrine\ORM\NoResultException;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\LockMode;

abstract class BaseRepository extends EntityRepository
{
    /**
     * (non-PHPdoc)
     * @see \Doctrine\ORM\EntityRepository::find()
     */
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        $result = parent::find($id, $lockMode, $lockVersion);

        if (!$result) throw new NoResultException('No result was found for query although at least one row was expected.');
        return $result;
    }
}

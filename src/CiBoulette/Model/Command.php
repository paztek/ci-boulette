<?php
namespace CiBoulette\Model;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Table(name="command")
 * @Entity(repositoryClass="\CiBoulette\Repository\CommandRepository")
 */
class Command
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @Column(name="position", type="integer", nullable=false)
     */
    protected $position;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var boolean
     *
     * @Column(name="active", type="boolean", nullable=false)
     */
    protected $active;

    /**
     * @var string
     *
     * @Column(name="command", type="text", nullable=false)
     */
    protected $command;

    /**
     * @var \CiBoulette\Model\Repository
     *
     * @ManyToOne(targetEntity="Repository", inversedBy="commands")
     * @JoinColumn(name="repository_id", referencedColumnName="id")
     */
    protected $repository;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="\CiBoulette\Model\Execution", mappedBy="command")
     * @OrderBy({"timestamp" = "DESC"})
     */
    protected $executions;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param  integer $position
     * @return Command
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Command
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set command
     *
     * @param  string  $command
     * @return Command
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set repository
     *
     * @param  \CiBoulette\Model\Repository $repository
     * @return Command
     */
    public function setRepository(\CiBoulette\Model\Repository $repository = null)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return \CiBoulette\Model\Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set active
     *
     * @param  boolean $active
     * @return Command
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->executions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add executions
     *
     * @param  \CiBoulette\Model\Execution $executions
     * @return Command
     */
    public function addExecution(\CiBoulette\Model\Execution $executions)
    {
        $this->executions[] = $executions;

        return $this;
    }

    /**
     * Remove executions
     *
     * @param \CiBoulette\Model\Execution $executions
     */
    public function removeExecution(\CiBoulette\Model\Execution $executions)
    {
        $this->executions->removeElement($executions);
    }

    /**
     * Get executions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExecutions()
    {
        return $this->executions;
    }
}

<?php
namespace CiBoulette\Model;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Table(name="push")
 * @Entity()
 */
class Push
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
     * @var string
     *
     * @Column(name="ref", type="string", length=255)
     */
    protected $ref;

    /**
     * @var \DateTime
     *
     * @Column(name="timestamp", type="datetime")
     */
    protected $timestamp;

    /**
     * @var \CiBoulette\Model\Commit
     *
     * @OneToOne(targetEntity="Commit", inversedBy="beforePush")
     * @JoinColumn(name="before_id", referencedColumnName="id", nullable=true)
     */
    protected $before;

    /**
     * @var \CiBoulette\Model\Commit
     *
     * @OneToOne(targetEntity="\CiBoulette\Model\Commit", inversedBy="afterPush")
     * @JoinColumn(name="after_id", referencedColumnName="id")
     */
    protected $after;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="\CiBoulette\Model\Commit", mappedBy="push")
     * @OrderBy({"timestamp" = "DESC"})
     */
    protected $commits;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="\CiBoulette\Model\Execution", mappedBy="push")
     * @OrderBy({"timestamp" = "DESC"})
     */
    protected $executions;

    /**
     * @var \CiBoulette\Model\Repository
     *
     * @ManyToOne(targetEntity="Repository", inversedBy="pushes")
     * @JoinColumn(name="repository_id", referencedColumnName="id")
     */
    protected $repository;

    public function __construct()
    {
        $this->commits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getRef();
    }

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
     * Set ref
     *
     * @param string $ref
     * @return Push
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Push
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set before
     *
     * @param \CiBoulette\Model\Commit $before
     * @return Push
     */
    public function setBefore(\CiBoulette\Model\Commit $before = null)
    {
        $this->before = $before;
    
        return $this;
    }

    /**
     * Get before
     *
     * @return \CiBoulette\Model\Commit 
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * Set after
     *
     * @param \CiBoulette\Model\Commit $after
     * @return Push
     */
    public function setAfter(\CiBoulette\Model\Commit $after = null)
    {
        $this->after = $after;
    
        return $this;
    }

    /**
     * Get after
     *
     * @return \CiBoulette\Model\Commit 
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * Add commits
     *
     * @param \CiBoulette\Model\Commit $commits
     * @return Push
     */
    public function addCommit(\CiBoulette\Model\Commit $commits)
    {
        $this->commits[] = $commits;
    
        return $this;
    }

    /**
     * Remove commits
     *
     * @param \CiBoulette\Model\Commit $commits
     */
    public function removeCommit(\CiBoulette\Model\Commit $commits)
    {
        $this->commits->removeElement($commits);
    }

    /**
     * Get commits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommits()
    {
        return $this->commits;
    }

    /**
     * Set repository
     *
     * @param \CiBoulette\Model\Repository $repository
     * @return Push
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
     * Add executions
     *
     * @param \CiBoulette\Model\Execution $executions
     * @return Push
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
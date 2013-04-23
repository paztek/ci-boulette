<?php
namespace CiBoulette\Model;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @Table(name="repositories")
 * @Entity(repositoryClass="\CiBoulette\Repository\RepositoryRepository")
 */
class Repository
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
     * @Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @Column(name="url", type="string", length=255, nullable=false)
     */
    protected $url;

    /**
     * @var boolean
     *
     * @Column(name="active", type="boolean", nullable=false)
     */
    protected $active;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="Command", mappedBy="repository")
     * @OrderBy({"position" = "ASC"})
     */
    protected $commands;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="Push", mappedBy="repository")
     * @OrderBy({"timestamp" = "DESC"})
     */
    protected $pushes;

    public function __construct()
    {
        $this->commands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pushes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  string     $name
     * @return Repository
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string     $url
     * @return Repository
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  boolean    $active
     * @return Repository
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
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
     * Add command
     *
     * @param  \CiBoulette\Model\Command $command
     * @return Repository
     */
    public function addCommand(\CiBoulette\Model\Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Remove command
     *
     * @param \CiBoulette\Model\Command $command
     */
    public function removeCommand(\CiBoulette\Model\Command $command)
    {
        $this->commands->removeElement($command);
    }

    /**
     * Get commands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Add pushes
     *
     * @param  \CiBoulette\Model\Push $pushes
     * @return Repository
     */
    public function addPushe(\CiBoulette\Model\Push $pushes)
    {
        $this->pushes[] = $pushes;

        return $this;
    }

    /**
     * Remove pushes
     *
     * @param \CiBoulette\Model\Push $pushes
     */
    public function removePushe(\CiBoulette\Model\Push $pushes)
    {
        $this->pushes->removeElement($pushes);
    }

    /**
     * Get pushes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPushes()
    {
        return $this->pushes;
    }
}

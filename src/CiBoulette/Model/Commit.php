<?php
namespace CiBoulette\Model;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Table(name="commits")
 * @Entity(repositoryClass="CiBoulette\Repository\CommitRepository")
 */
class Commit
{
    /**
     * @var string
     *
     * @Id
     * @Column(name="hash", type="string", length=255)
     */
    protected $hash;

    /**
     * @var string
     *
     * @Column(name="message", type="string", length=255)
     */
    protected $message;

    /**
     * @var \DateTime
     *
     * @Column(name="timestamp", type="datetime")
     */
    protected $timestamp;

    /**
     * @var string
     *
     * @Column(name="url", type="string", length=255)
     */
    protected $url;

    /**
     * @var string
     *
     * @Column(name="author", type="string", length=255)
     */
    protected $author;

    /**
     * @var \CiBoulette\Model\Push
     *
     * @ManyToOne(targetEntity="Push", inversedBy="commits")
     * @JoinColumn(name="push_id", referencedColumnName="id")
     */
    protected $push;

    /**
     * @var \CiBoulette\Model\Push
     *
     * @OneToMany(targetEntity="Push", mappedBy="before")
     */
    protected $beforePushes;

    /**
     * @var \CiBoulette\Model\Push
     *
     * @OneToMany(targetEntity="Push", mappedBy="after")
     */
    protected $afterPushes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->beforePushes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->afterPushes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getHash();
    }

    /**
     * Set message
     *
     * @param  string $message
     * @return Commit
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime $timestamp
     * @return Commit
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
     * Set url
     *
     * @param  string $url
     * @return Commit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set author
     *
     * @param  string $author
     * @return Commit
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set push
     *
     * @param  \CiBoulette\Model\Push $push
     * @return Commit
     */
    public function setPush(\CiBoulette\Model\Push $push = null)
    {
        $this->push = $push;

        return $this;
    }

    /**
     * Get push
     *
     * @return \CiBoulette\Model\Push
     */
    public function getPush()
    {
        return $this->push;
    }

    /**
     * Set hash
     *
     * @param  string $hash
     * @return Commit
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Add beforePushes
     *
     * @param  \CiBoulette\Model\Push $beforePushes
     * @return Commit
     */
    public function addBeforePushe(\CiBoulette\Model\Push $beforePushes)
    {
        $this->beforePushes[] = $beforePushes;

        return $this;
    }

    /**
     * Remove beforePushes
     *
     * @param \CiBoulette\Model\Push $beforePushes
     */
    public function removeBeforePushe(\CiBoulette\Model\Push $beforePushes)
    {
        $this->beforePushes->removeElement($beforePushes);
    }

    /**
     * Get beforePushes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBeforePushes()
    {
        return $this->beforePushes;
    }

    /**
     * Add afterPushes
     *
     * @param  \CiBoulette\Model\Push $afterPushes
     * @return Commit
     */
    public function addAfterPushe(\CiBoulette\Model\Push $afterPushes)
    {
        $this->afterPushes[] = $afterPushes;

        return $this;
    }

    /**
     * Remove afterPushes
     *
     * @param \CiBoulette\Model\Push $afterPushes
     */
    public function removeAfterPushe(\CiBoulette\Model\Push $afterPushes)
    {
        $this->afterPushes->removeElement($afterPushes);
    }

    /**
     * Get afterPushes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAfterPushes()
    {
        return $this->afterPushes;
    }
}

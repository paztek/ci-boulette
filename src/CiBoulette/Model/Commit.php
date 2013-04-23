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
 * @Table(name="commit")
 * @Entity()
 */
class Commit
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
     * @OneToOne(targetEntity="Push", mappedBy="before")
     */
    protected $beforePush;

    /**
     * @var \CiBoulette\Model\Push
     *
     * @OneToOne(targetEntity="Push", mappedBy="after")
     */
    protected $afterPush;

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
     * Set message
     *
     * @param string $message
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
     * @param \DateTime $timestamp
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
     * @param string $url
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
     * @param string $author
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
     * @param \CiBoulette\Model\Push $push
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
     * Set beforePush
     *
     * @param \CiBoulette\Model\Push $beforePush
     * @return Commit
     */
    public function setBeforePush(\CiBoulette\Model\Push $beforePush = null)
    {
        $this->beforePush = $beforePush;
    
        return $this;
    }

    /**
     * Get beforePush
     *
     * @return \CiBoulette\Model\Push 
     */
    public function getBeforePush()
    {
        return $this->beforePush;
    }

    /**
     * Set afterPush
     *
     * @param \CiBoulette\Model\Push $afterPush
     * @return Commit
     */
    public function setAfterPush(\CiBoulette\Model\Push $afterPush = null)
    {
        $this->afterPush = $afterPush;
    
        return $this;
    }

    /**
     * Get afterPush
     *
     * @return \CiBoulette\Model\Push 
     */
    public function getAfterPush()
    {
        return $this->afterPush;
    }
}
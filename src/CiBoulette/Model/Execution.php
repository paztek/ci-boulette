<?php
namespace CiBoulette\Model;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Table(name="execution")
 * @Entity(repositoryClass="\CiBoulette\Repository\ExecutionRepository")
 */
class Execution
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
     * @var \DateTime
     *
     *
     * @Column(name="timestamp", type="datetime", nullable=false)
     */
    protected $timestamp;

    /**
     * @var string
     *
     *
     * @Column(name="runnedCommand", type="text", nullable=false)
     */
    protected $runnedCommand;

    /**
     * @var integer
     *
     * @Column(name="errCode", type="integer", nullable=false)
     */
    protected $errCode;

    /**
     * @var integer
     *
     * @Column(name="shellResult", type="text", nullable=false)
     */
    protected $shellResult;

    /**
     * @var \CiBoulette\Model\Command
     *
     * @ManyToOne(targetEntity="Command", inversedBy="executions")
     * @JoinColumn(name="command_id", referencedColumnName="id")
     */
    protected $command;

    /**
     * @var \CiBoulette\Model\Push
     *
     * @ManyToOne(targetEntity="Push", inversedBy="executions")
     * @JoinColumn(name="push_id", referencedColumnName="id")
     */
    protected $push;

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
     * Set timestamp
     *
     * @param  \DateTime $timestamp
     * @return Execution
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
     * Set runnedCommand
     *
     * @param  string    $runnedCommand
     * @return Execution
     */
    public function setRunnedCommand($runnedCommand)
    {
        $this->runnedCommand = $runnedCommand;

        return $this;
    }

    /**
     * Get runnedCommand
     *
     * @return string
     */
    public function getRunnedCommand()
    {
        return $this->runnedCommand;
    }

    /**
     * Set errCode
     *
     * @param  integer   $errCode
     * @return Execution
     */
    public function setErrCode($errCode)
    {
        $this->errCode = $errCode;

        return $this;
    }

    /**
     * Get errCode
     *
     * @return integer
     */
    public function getErrCode()
    {
        return $this->errCode;
    }

    /**
     * Set shellResult
     *
     * @param  string    $shellResult
     * @return Execution
     */
    public function setShellResult($shellResult)
    {
        $this->shellResult = $shellResult;

        return $this;
    }

    /**
     * Get shellResult
     *
     * @return string
     */
    public function getShellResult()
    {
        return $this->shellResult;
    }

    /**
     * Set command
     *
     * @param  \CiBoulette\Model\Command $command
     * @return Execution
     */
    public function setCommand(\CiBoulette\Model\Command $command = null)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \CiBoulette\Model\Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set push
     *
     * @param  \CiBoulette\Model\Push $push
     * @return Execution
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
}

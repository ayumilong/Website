<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="sender", columns={"sender"}), @ORM\Index(name="receivor", columns={"receivor"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=40, nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=200, nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendtime", type="date", nullable=true)
     */
    private $sendtime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="receivetime", type="date", nullable=true)
     */
    private $receivetime;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="isread", type="integer", nullable=false)
     */
    private $isread;

    /**
     * @var integer
     *
     * @ORM\Column(name="messageid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receivor", referencedColumnName="username")
     * })
     */
    private $receivor;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender", referencedColumnName="username")
     * })
     */
    private $sender;



    /**
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sendtime
     *
     * @param \DateTime $sendtime
     * @return Message
     */
    public function setSendtime($sendtime)
    {
        $this->sendtime = $sendtime;

        return $this;
    }

    /**
     * Get sendtime
     *
     * @return \DateTime 
     */
    public function getSendtime()
    {
        return $this->sendtime;
    }

    /**
     * Set receivetime
     *
     * @param \DateTime $receivetime
     * @return Message
     */
    public function setReceivetime($receivetime)
    {
        $this->receivetime = $receivetime;

        return $this;
    }

    /**
     * Get receivetime
     *
     * @return \DateTime 
     */
    public function getReceivetime()
    {
        return $this->receivetime;
    }

    /**
     * Get messageid
     *
     * @return integer 
     */
    public function getMessageid()
    {
        return $this->messageid;
    }
    
    /**
     * Get isread
     *
     * @return integer 
     */
    public function getIsread()
    {
        return $this->isread;
    }
    
    /**
     * Set isread
     *
     * @param \DateTime $isread
     * @return Message
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;

        return $this;
    }

    /**
     * Set receivor
     *
     * @param \MSS\CoreBundle\Entity\User $receivor
     * @return Message
     */
    public function setReceivor(\MSS\CoreBundle\Entity\User $receivor = null)
    {
        $this->receivor = $receivor;

        return $this;
    }

    /**
     * Get receivor
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getReceivor()
    {
        return $this->receivor;
    }

    /**
     * Set sender
     *
     * @param \MSS\CoreBundle\Entity\User $sender
     * @return Message
     */
    public function setSender(\MSS\CoreBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }
}

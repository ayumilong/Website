<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscribechannel
 *
 * @ORM\Table(name="subscribechannel", indexes={@ORM\Index(name="publisher", columns={"publisher"}), @ORM\Index(name="observer", columns={"observer"})})
 * @ORM\Entity
 */
class Subscribechannel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="subscribid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $subscribid;

    /**
     * @var string
     *
     * @ORM\Column(name="observer", type="string", length=20, nullable=false)
     */
    private $observer;
    
    /**
     * @var string
     *
     * @ORM\Column(name="publisher", type="string", length=20, nullable=false)
     */
    private $publisher;
    
    /**
     * @var string
     *
     * @ORM\Column(name="channeltype", type="string", length=20, nullable=false)
     */
    private $channeltype;



    /**
     * Get subscribid
     *
     * @return integer 
     */
    public function getSubscribid()
    {
        return $this->subscribid;
    }

    /**
     * Set observer
     *
     * @param string $observer
     * @return Subscribechannel
     */
    public function setObserver($observer)
    {
        $this->observer = $observer;

        return $this;
    }

    /**
     * Get observer
     *
     * @return string 
     */
    public function getObserver()
    {
        return $this->observer;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     * @return Subscribechannel
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }
    
        /**
     * Set channeltype
     *
     * @param string $channeltype
     * @return Subscribechannel
     */
    public function setChanneltype($channeltype)
    {
        $this->channeltype = $channeltype;

        return $this;
    }

    /**
     * Get channeltype
     *
     * @return string 
     */
    public function getChanneltype()
    {
        return $this->channeltype;
    }
}

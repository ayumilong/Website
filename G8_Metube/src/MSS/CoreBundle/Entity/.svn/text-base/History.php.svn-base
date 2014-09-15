<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity
 */
class History
{
    /**
     * @var integer
     *
     * @ORM\Column(name="mediatype", type="integer", nullable=false)
     */
    private $mediatype;

    /**
     * @var integer
     *
     * @ORM\Column(name="mediaid", type="integer", nullable=false)
     */
    private $mediaid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="browsetime", type="date", nullable=true)
     */
    private $browsetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="historyid", type="integer", length=10)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $historyid;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=40, nullable=false)
     */
    private $keywords;

    /**
     * Set mediatype
     *
     * @param integer $mediatype
     * @return History
     */
    public function setMediatype($mediatype)
    {
        $this->mediatype = $mediatype;

        return $this;
    }

    /**
     * Get mediatype
     *
     * @return integer 
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }
    
    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Audiomedia
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set mediaid
     *
     * @param integer $mediaid
     * @return History
     */
    public function setMediaid($mediaid)
    {
        $this->mediaid = $mediaid;

        return $this;
    }

    /**
     * Get mediaid
     *
     * @return integer 
     */
    public function getMediaid()
    {
        return $this->mediaid;
    }

    /**
     * Set browsetime
     *
     * @param \DateTime $browsetime
     * @return History
     */
    public function setBrowsetime($browsetime)
    {
        $this->browsetime = $browsetime;

        return $this;
    }

    /**
     * Get browsetime
     *
     * @return \DateTime 
     */
    public function getBrowsetime()
    {
        return $this->browsetime;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Set username
     *
     * @param string $username
     * @return History
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    
    /**
     * Get historyid
     *
     * @return integer 
     */
    public function getHistoryid()
    {
        return $this->historyid;
    }
}

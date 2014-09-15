<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Playlist
 *
 * @ORM\Table(name="playlist", indexes={@ORM\Index(name="creator", columns={"creator"})})
 * @ORM\Entity
 */
class Playlist
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=40, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="isfavorate", type="integer", nullable=true)
     */
    private $isfavorate;

    /**
     * @var string
     *
     * @ORM\Column(name="audiocontent", type="string", length=200, nullable=true)
     */
    private $audiocontent;
    
    /**
     * @var string
     *
     * @ORM\Column(name="vediocontent", type="string", length=200, nullable=true)
     */
    private $vediocontent;

    /**
     * @var integer
     *
     * @ORM\Column(name="plid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $plid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator", referencedColumnName="username")
     * })
     */
    private $creator;



    /**
     * Set title
     *
     * @param string $title
     * @return Playlist
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isfavorate
     *
     * @param integer $isfavorate
     * @return Playlist
     */
    public function setIsfavorate($isfavorate)
    {
        $this->isfavorate = $isfavorate;

        return $this;
    }

    /**
     * Get isfavorate
     *
     * @return integer 
     */
    public function getIsfavorate()
    {
        return $this->isfavorate;
    }

    /**
     * Set audiocontent
     *
     * @param string $audiocontent
     * @return Playlist
     */
    public function setAudiocontent($audiocontent)
    {
        $this->audiocontent = $audiocontent;

        return $this;
    }

    /**
     * Get vediocontent
     *
     * @return string 
     */
    public function getVediocontent()
    {
        return $this->vediocontent;
    }
    
    /**
     * Set vediocontent
     *
     * @param string $audiocontent
     * @return Playlist
     */
    public function setVediocontent($vediocontent)
    {
        $this->vediocontent = $vediocontent;

        return $this;
    }

    /**
     * Get Audiocontent
     *
     * @return string 
     */
    public function getAudiocontent()
    {
        return $this->audiocontent;
    }

    /**
     * Get plid
     *
     * @return integer 
     */
    public function getPlid()
    {
        return $this->plid;
    }

    /**
     * Set creator
     *
     * @param \MSS\CoreBundle\Entity\User $creator
     * @return Playlist
     */
    public function setCreator(\MSS\CoreBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
}

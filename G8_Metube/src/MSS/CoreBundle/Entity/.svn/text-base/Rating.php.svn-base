<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating", indexes={@ORM\Index(name="rater", columns={"rater"})})
 * @ORM\Entity
 */
class Rating
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
     * @var string
     *
     * @ORM\Column(name="stars", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $stars;

    /**
     * @var integer
     *
     * @ORM\Column(name="rateid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rateid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rater", referencedColumnName="username")
     * })
     */
    private $rater;



    /**
     * Set mediatype
     *
     * @param integer $mediatype
     * @return Rating
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
     * Set mediaid
     *
     * @param integer $mediaid
     * @return Rating
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
     * Set stars
     *
     * @param string $stars
     * @return Rating
     */
    public function setStars($stars)
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return string 
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * Get rateid
     *
     * @return integer 
     */
    public function getRateid()
    {
        return $this->rateid;
    }

    /**
     * Set rater
     *
     * @param \MSS\CoreBundle\Entity\User $rater
     * @return Rating
     */
    public function setRater(\MSS\CoreBundle\Entity\User $rater = null)
    {
        $this->rater = $rater;

        return $this;
    }

    /**
     * Get rater
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getRater()
    {
        return $this->rater;
    }
}

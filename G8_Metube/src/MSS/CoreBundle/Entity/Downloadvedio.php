<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Downloadvedio
 *
 * @ORM\Table(name="downloadvedio")
 * @ORM\Entity
 */
class Downloadvedio
{
    /**
     * @var string
     *
     * @ORM\Column(name="downloadname", type="string", length=20, nullable=false)
     */
    private $downloadname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="downloadtime", type="date", nullable=false)
     */
    private $downloadtime;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloadvedioid", type="integer", nullable=false)
     */
    private $downloadvedioid;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloadid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $downloadid;


    /**
     * Set downloadname
     *
     * @param string $downloadname
     * @return Downloadvedio
     */
    public function setDownloadname($downloadname)
    {
        $this->downloadname = $downloadname;

        return $this;
    }

    /**
     * Get downloadname
     *
     * @return string 
     */
    public function getDownloadname()
    {
        return $this->downloadname;
    }

    /**
     * Set downloadtime
     *
     * @param \DateTime $downloadtime
     * @return Downloadvedio
     */
    public function setDownloadtime($downloadtime)
    {
        $this->downloadtime = $downloadtime;

        return $this;
    }

    /**
     * Get downloadtime
     *
     * @return \DateTime 
     */
    public function getDownloadtime()
    {
        return $this->downloadtime;
    }

    /**
     * Set downloadvedioid
     *
     * @param integer $downloadvedioid
     * @return Downloadvedio
     */
    public function setDownloadvedioid($downloadvedioid)
    {
        $this->downloadvedioid = $downloadvedioid;

        return $this;
    }

    /**
     * Get downloadvedioid
     *
     * @return integer 
     */
    public function getDownloadvedioid()
    {
        return $this->downloadvedioid;
    }

    /**
     * Get downloadid
     *
     * @return integer 
     */
    public function getDownloadid()
    {
        return $this->downloadid;
    }
}
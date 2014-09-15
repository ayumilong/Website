<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Downloadaudio
 *
 * @ORM\Table(name="downloadaudio")
 * @ORM\Entity
 */
class Downloadaudio
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
     * @ORM\Column(name="downloadaudioid", type="integer", nullable=false)
     */
    private $downloadaudioid;

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
     * @return Downloadaudio
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
     * @return Downloadaudio
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
     * Set downloadaudioid
     *
     * @param integer $downloadaudioid
     * @return Downloadaudio
     */
    public function setDownloadaudioid($downloadaudioid)
    {
        $this->downloadaudioid = $downloadaudioid;

        return $this;
    }

    /**
     * Get downloadaudioid
     *
     * @return integer 
     */
    public function getDownloadaudioid()
    {
        return $this->downloadaudioid;
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

<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Downloadtext
 *
 * @ORM\Table(name="downloadtext")
 * @ORM\Entity
 */
class Downloadtext
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
     * @ORM\Column(name="downloadtextid", type="integer", nullable=false)
     */
    private $downloadtextid;

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
     * @return Downloadtext
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
     * @return Downloadtext
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
     * Set downloadtextid
     *
     * @param integer $downloadtextid
     * @return Downloadtext
     */
    public function setDownloadtextid($downloadtextid)
    {
        $this->downloadtextid = $downloadtextid;

        return $this;
    }

    /**
     * Get downloadtextid
     *
     * @return integer 
     */
    public function getDownloadtextid()
    {
        return $this->downloadtextid;
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

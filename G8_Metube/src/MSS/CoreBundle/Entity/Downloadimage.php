<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Downloadimage
 *
 * @ORM\Table(name="downloadimage")
 * @ORM\Entity
 */
class Downloadimage
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
     * @ORM\Column(name="downloadimageid", type="integer", nullable=false)
     */
    private $downloadimageid;

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
     * @return Downloadimage
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
     * @return Downloadimage
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
     * Set downloadimageid
     *
     * @param integer $downloadimageid
     * @return Downloadimage
     */
    public function setDownloadimageid($downloadimageid)
    {
        $this->downloadimageid = $downloadimageid;

        return $this;
    }

    /**
     * Get downloadimageid
     *
     * @return integer 
     */
    public function getDownloadimageid()
    {
        return $this->downloadimageid;
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

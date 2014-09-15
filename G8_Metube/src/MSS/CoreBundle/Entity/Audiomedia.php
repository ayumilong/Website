<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audiomedia
 *
 * @ORM\Table(name="audiomedia")
 * @ORM\Entity
 */
class Audiomedia
{
    /**
     * @var string
     *
     * @ORM\Column(name="uploadname", type="string", length=20, nullable=false)
     */
    private $uploadname;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=40, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=40, nullable=false)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="uploadpath", type="string", length=100, nullable=false)
     */
    private $uploadpath;
    
    /**
     * @var string
     *
     * @ORM\Column(name="$uploadprefix", type="string", length=100, nullable=false)
     */
    private $uploadprefix;
    
    /**
     * @var coverpath
     *
     * @ORM\Column(name="$coverpath", type="string", length=100, nullable=false)
     */
    private $coverpath = "images/default_cover.jpg";

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatetime", type="date", nullable=false)
     */
    private $updatetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="viewtimes", type="integer", nullable=true)
     */
    private $viewtimes;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloadtimes", type="integer", nullable=true)
     */
    private $downloadtimes;

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer", nullable=true)
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikes", type="integer", nullable=true)
     */
    private $dislikes;

    /**
     * @var integer
     *
     * @ORM\Column(name="isshare", type="integer", nullable=true)
     */
    private $isshare;

    /**
     * @var integer
     *
     * @ORM\Column(name="security", type="integer", nullable=true)
     */
    private $security;

    /**
     * @var integer
     *
     * @ORM\Column(name="audioid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $audioid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dislikes = 0;
        $this->likes = 0;
        $this->viewtimes = 0;
        $this->downloadtimes = 0;
        $this->isshare = 0; //Default for share
        $this->security = 0; //Default for public
    }

    /**
     * Set uploadname
     *
     * @param string $uploadname
     * @return Audiomedia
     */
    public function setUploadname($uploadname)
    {
        $this->uploadname = $uploadname;

        return $this;
    }

    /**
     * Get uploadname
     *
     * @return string 
     */
    public function getUploadname()
    {
        return $this->uploadname;
    }

    /**
     * Set coverpath
     *
     * @param string $coverpath
     * @return audiomedia
     */
    public function setCoverpath($coverpath)
    {
        $this->coverpath = $coverpath;

        return $this;
    }

    /**
     * Get coverpath
     *
     * @return string 
     */
    public function getCoverpath()
    {
        return $this->coverpath;
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return Audiomedia
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
     * Set description
     *
     * @param string $description
     * @return Audiomedia
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set uploadpath
     *
     * @param string $uploadpath
     * @return Imagemedia
     */
    public function setUploadpath($uploadpath)
    {
        $this->uploadpath = $uploadpath;

        return $this;
    }

    /**
     * Get uploadpath
     *
     * @return string 
     */
    public function getUploadpath()
    {
        return $this->uploadpath;
    }
    
    /**
     * Set uploadprefix
     *
     * @param string uploadprefix
     * @return vediomedia
     */
    public function setUploadprefix($uploadprefix)
    {
        $this->uploadprefix = $uploadprefix;

        return $this;
    }

    /**
     * Get uploadprefix
     *
     * @return string 
     */
    public function getUploadprefix()
    {
        return $this->uploadprefix;
    }

    /**
     * Set updatetime
     *
     * @param \DateTime $updatetime
     * @return Audiomedia
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = $updatetime;

        return $this;
    }

    /**
     * Get updatetime
     *
     * @return \DateTime 
     */
    public function getUpdatetime()
    {
        return $this->updatetime;
    }

    /**
     * Set viewtimes
     *
     * @param integer $viewtimes
     * @return Audiomedia
     */
    public function setViewtimes($viewtimes)
    {
        $this->viewtimes = $viewtimes;

        return $this;
    }

    /**
     * Get viewtimes
     *
     * @return integer 
     */
    public function getViewtimes()
    {
        return $this->viewtimes;
    }

    /**
     * Set downloadtimes
     *
     * @param integer $downloadtimes
     * @return Audiomedia
     */
    public function setDownloadtimes($downloadtimes)
    {
        $this->downloadtimes = $downloadtimes;

        return $this;
    }

    /**
     * Get downloadtimes
     *
     * @return integer 
     */
    public function getDownloadtimes()
    {
        return $this->downloadtimes;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     * @return Audiomedia
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer 
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set dislikes
     *
     * @param integer $dislikes
     * @return Audiomedia
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * Get dislikes
     *
     * @return integer 
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * Set isshare
     *
     * @param integer $isshare
     * @return Audiomedia
     */
    public function setIsshare($isshare)
    {
        $this->isshare = $isshare;

        return $this;
    }

    /**
     * Get isshare
     *
     * @return integer 
     */
    public function getIsshare()
    {
        return $this->isshare;
    }

    /**
     * Set security
     *
     * @param integer $security
     * @return Audiomedia
     */
    public function setSecurity($security)
    {
        $this->security = $security;

        return $this;
    }

    /**
     * Get security
     *
     * @return integer 
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Get audioid
     *
     * @return integer 
     */
    public function getAudioid()
    {
        return $this->audioid;
    }
    
    public function getFileName(){
        return substr($this->uploadpath, 7);
    }
}

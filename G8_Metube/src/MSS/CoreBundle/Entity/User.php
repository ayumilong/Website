<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="passwd", type="string", length=10, nullable=false)
     */
    private $passwd;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=40, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=40, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="photopath", type="string", length=100, nullable=true)
     */
    private $photopath;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=false)
     */
    private $sex;

    /**
     * @var integer
     *
     * @ORM\Column(name="texts", type="integer", nullable=false)
     */
    private $texts;

    /**
     * @var integer
     *
     * @ORM\Column(name="images", type="integer", nullable=false)
     */
    private $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="audios", type="integer", nullable=false)
     */
    private $audios;

    /**
     * @var integer
     *
     * @ORM\Column(name="vedios", type="integer", nullable=false)
     */
    private $vedios;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=1, nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->active = "N";
        $this->address ="206B";
        $this->audios = 0;
        $this->images = 0;
        $this->photopath = "profiles/default.jpg";
        $this->sex = "F";
        $this->status = 1;
        $this->texts = 0;
        $this->vedios = 0;
    }



    /**
     * Set passwd
     *
     * @param string $passwd
     * @return User
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;

        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set photopath
     *
     * @param string $photopath
     * @return User
     */
    public function setPhotopath($photopath)
    {
        $this->photopath = $photopath;

        return $this;
    }

    /**
     * Get photopath
     *
     * @return string 
     */
    public function getPhotopath()
    {
        return $this->photopath;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set texts
     *
     * @param integer $texts
     * @return User
     */
    public function setTexts($texts)
    {
        $this->texts = $texts;

        return $this;
    }

    /**
     * Get texts
     *
     * @return integer 
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * Set images
     *
     * @param integer $images
     * @return User
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return integer 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set audios
     *
     * @param integer $audios
     * @return User
     */
    public function setAudios($audios)
    {
        $this->audios = $audios;

        return $this;
    }

    /**
     * Get audios
     *
     * @return integer 
     */
    public function getAudios()
    {
        return $this->audios;
    }

    /**
     * Set vedios
     *
     * @param integer $vedios
     * @return User
     */
    public function setVedios($vedios)
    {
        $this->vedios = $vedios;

        return $this;
    }

    /**
     * Get vedios
     *
     * @return integer 
     */
    public function getVedios()
    {
        return $this->vedios;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
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
}

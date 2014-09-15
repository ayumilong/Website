<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contactlist
 *
 * @ORM\Table(name="contactlist", indexes={@ORM\Index(name="fromname", columns={"fromname"}), @ORM\Index(name="toname", columns={"toname"})})
 * @ORM\Entity
 */
class Contactlist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="isfriend", type="integer", nullable=true)
     */
    private $isfriend;

    /**
     * @var integer
     *
     * @ORM\Column(name="block", type="integer", nullable=true)
     */
    private $block;

    /**
     * @var integer
     *
     * @ORM\Column(name="blocktype", type="integer", nullable=true)
     */
    private $blocktype;

    /**
     * @var string
     *
     * @ORM\Column(name="blockcontent", type="string", length=100, nullable=true)
     */
    private $blockcontent;

    /**
     * @var integer
     *
     * @ORM\Column(name="contactid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contactid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="toname", referencedColumnName="username")
     * })
     */
    private $toname;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fromname", referencedColumnName="username")
     * })
     */
    private $fromname;



    /**
     * Set isfriend
     *
     * @param integer $isfriend
     * @return Contactlist
     */
    public function setIsfriend($isfriend)
    {
        $this->isfriend = $isfriend;

        return $this;
    }

    /**
     * Get isfriend
     *
     * @return integer 
     */
    public function getIsfriend()
    {
        return $this->isfriend;
    }

    /**
     * Set block
     *
     * @param integer $block
     * @return Contactlist
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return integer 
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set blocktype
     *
     * @param integer $blocktype
     * @return Contactlist
     */
    public function setBlocktype($blocktype)
    {
        $this->blocktype = $blocktype;

        return $this;
    }

    /**
     * Get blocktype
     *
     * @return integer 
     */
    public function getBlocktype()
    {
        return $this->blocktype;
    }

    /**
     * Set blockcontent
     *
     * @param string $blockcontent
     * @return Contactlist
     */
    public function setBlockcontent($blockcontent)
    {
        $this->blockcontent = $blockcontent;

        return $this;
    }

    /**
     * Get blockcontent
     *
     * @return string 
     */
    public function getBlockcontent()
    {
        return $this->blockcontent;
    }

    /**
     * Get contactid
     *
     * @return integer 
     */
    public function getContactid()
    {
        return $this->contactid;
    }

    /**
     * Set toname
     *
     * @param \MSS\CoreBundle\Entity\User $toname
     * @return Contactlist
     */
    public function setToname(\MSS\CoreBundle\Entity\User $toname = null)
    {
        $this->toname = $toname;

        return $this;
    }

    /**
     * Get toname
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getToname()
    {
        return $this->toname;
    }

    /**
     * Set fromname
     *
     * @param \MSS\CoreBundle\Entity\User $fromname
     * @return Contactlist
     */
    public function setFromname(\MSS\CoreBundle\Entity\User $fromname = null)
    {
        $this->fromname = $fromname;

        return $this;
    }

    /**
     * Get fromname
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getFromname()
    {
        return $this->fromname;
    }
}

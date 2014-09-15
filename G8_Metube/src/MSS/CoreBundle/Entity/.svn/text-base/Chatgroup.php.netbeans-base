<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chatgroup
 *
 * @ORM\Table(name="chatgroup")
 * @ORM\Entity
 */
class Chatgroup
{
    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=20, nullable=false)
     */
    private $groupname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=40, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createtime", type="date", nullable=false)
     */
    private $createtime;

    /**
     * @var integer
     *
     * @ORM\Column(name="groupid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupid;

    /**
     * Set groupname
     *
     * @param string $groupname
     * @return Chatgroup
     */
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;

        return $this;
    }

    /**
     * Get groupname
     *
     * @return string 
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Chatgroup
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
     * Set createtime
     *
     * @param \DateTime $createtime
     * @return Chatgroup
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;

        return $this;
    }

    /**
     * Get createtime
     *
     * @return \DateTime 
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * Get groupid
     *
     * @return integer 
     */
    public function getGroupid()
    {
        return $this->groupid;
    }
}

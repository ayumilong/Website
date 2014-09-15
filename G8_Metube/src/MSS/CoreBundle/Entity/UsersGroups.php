<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersGroups
 *
 * @ORM\Table(name="users_groups")
 * @ORM\Entity
 */
class UsersGroups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="isadmin", type="integer", nullable=true)
     */
    private $isadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="groupid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupid;



    /**
     * Set isadmin
     *
     * @param integer $isadmin
     * @return UsersGroups
     */
    public function setIsadmin($isadmin)
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    /**
     * Get isadmin
     *
     * @return integer 
     */
    public function getIsadmin()
    {
        return $this->isadmin;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return UsersGroups
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

    /**
     * Set groupid
     *
     * @param integer $groupid
     * @return UsersGroups
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;

        return $this;
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

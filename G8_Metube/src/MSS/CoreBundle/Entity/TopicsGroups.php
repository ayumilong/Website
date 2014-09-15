<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersGroups
 *
 * @ORM\Table(name="topics_groups")
 * @ORM\Entity
 */
class TopicsGroups
{

    /**
     * @var integer
     *
     * @ORM\Column(name="topicid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $topicid;

    /**
     * @var integer
     *
     * @ORM\Column(name="groupid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupid;

    /**
     * Set topicid
     *
     * @param integer $topicid
     * @return TopicsGroups
     */
    public function setTopicid($topicid)
    {
        $this->topicid = $topicid;

        return $this;
    }

    /**
     * Get topicid
     *
     * @return integer 
     */
    public function getTopicid()
    {
        return $this->topicid;
    }

    /**
     * Set groupid
     *
     * @param integer $groupid
     * @return TopicsGroups
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

<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity
 */
class Topic
{
    /**
     * @var string
     *
     * @ORM\Column(name="topicname", type="string", length=20, nullable=false)
     */
    private $topicname;
    
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
     * @ORM\Column(name="topicid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $topicid;

    /**
     * Set topicname
     *
     * @param string $topicname
     * @return Chatgroup
     */
    public function setTopicname($topicname)
    {
        $this->topicname = $topicname;

        return $this;
    }

    /**
     * Get topicname
     *
     * @return string 
     */
    public function getTopicname()
    {
        return $this->topicname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Topic
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
     * @return Topic
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
     * Get topicid
     *
     * @return integer 
     */
    public function getTopicid()
    {
        return $this->topicid;
    }

}

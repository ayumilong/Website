<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="poster", columns={"poster"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var \MSS\CoreBundle\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent", referencedColumnName="postid")
     * })
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=200, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createtime", type="date", nullable=false)
     */
    private $createtime;

    /**
     * @var integer
     *
     * @ORM\Column(name="postid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poster", referencedColumnName="username")
     * })
     */
    private $poster;
    
    /**
     * @var string
     *
     * @ORM\Column(name="replyto", type="string", length=20)
     */
    private $replyto;
    
    /**
     * @var \MSS\CoreBundle\Entity\Topic
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\Topic")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="topicid", referencedColumnName="topicid")
     * })
     */
    private $topicid;



    /**
     * Set parent
     *
     * @param Post $parent
     * @return Post
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

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
     * Set topicid
     *
     * @param integer $topicid
     * @return Post
     */
    public function setTopicid($topicid)
    {
        $this->topicid = $topicid;

        return $this;
    }

    /**
     * Get parent
     *
     * @return post 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createtime
     *
     * @param \DateTime $createtime
     * @return Post
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
     * Get postid
     *
     * @return integer 
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     * Set poster
     *
     * @param \MSS\CoreBundle\Entity\User $poster
     * @return Post
     */
    public function setPoster(\MSS\CoreBundle\Entity\User $poster = null)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getPoster()
    {
        return $this->poster;
    }
    
    /**
     * Set replyto
     *
     * @param string $replyto
     * @return Post
     */
    public function setReplyto($replyto)
    {
        $this->replyto = $replyto;

        return $this;
    }

    /**
     * Get replyto
     *
     * @return string 
     */
    public function getReplyto()
    {
        return $this->replyto;
    }
}

<?php

namespace MSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="commenter", columns={"commenter"})})
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="mediatype", type="integer", nullable=false)
     */
    private $mediatype;

    /**
     * @var integer
     *
     * @ORM\Column(name="mediaid", type="integer", nullable=false)
     */
    private $mediaid;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=200, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posttime", type="date", nullable=false)
     */
    private $posttime;

    /**
     * @var integer
     *
     * @ORM\Column(name="children", type="integer", nullable=true)
     */
    private $children;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * @var \MSS\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MSS\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commenter", referencedColumnName="username")
     * })
     */
    private $commenter;


    /**
     * Set parent
     *
     * @param integer $parent
     * @return Comments
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set mediatype
     *
     * @param integer $mediatype
     * @return Comments
     */
    public function setMediatype($mediatype)
    {
        $this->mediatype = $mediatype;

        return $this;
    }

    /**
     * Get mediatype
     *
     * @return integer 
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }

    /**
     * Set mediaid
     *
     * @param integer $mediaid
     * @return Comments
     */
    public function setMediaid($mediaid)
    {
        $this->mediaid = $mediaid;

        return $this;
    }

    /**
     * Get mediaid
     *
     * @return integer 
     */
    public function getMediaid()
    {
        return $this->mediaid;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comments
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
     * Set posttime
     *
     * @param \DateTime $posttime
     * @return Comments
     */
    public function setPosttime($posttime)
    {
        $this->posttime = $posttime;

        return $this;
    }

    /**
     * Get posttime
     *
     * @return \DateTime 
     */
    public function getPosttime()
    {
        return $this->posttime;
    }

    /**
     * Set children
     *
     * @param integer $children
     * @return Comments
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return integer 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get commentid
     *
     * @return integer 
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set commenter
     *
     * @param \MSS\CoreBundle\Entity\User $commenter
     * @return Comments
     */
    public function setCommenter(\MSS\CoreBundle\Entity\User $commenter = null)
    {
        $this->commenter = $commenter;

        return $this;
    }

    /**
     * Get commenter
     *
     * @return \MSS\CoreBundle\Entity\User 
     */
    public function getCommenter()
    {
        return $this->commenter;
    }
}

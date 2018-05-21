<?php

namespace AppBundle\Entity\blogusers;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * FOSUser
 *
 * @ORM\Table(name="blogusers_f_o_s_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\blogusers\FOSUserRepository")
 */
class FOSUser extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * FOSUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Post", mappedBy="FOSUser")
     */
    private $posts;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\blogusers\Post $post
     *
     * @return FOSUser
     */
    public function addPost(\AppBundle\Entity\blogusers\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\blogusers\Post $post
     */
    public function removePost(\AppBundle\Entity\blogusers\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}

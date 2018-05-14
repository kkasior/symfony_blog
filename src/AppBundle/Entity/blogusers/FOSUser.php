<?php

namespace AppBundle\Entity\blogusers;

use Doctrine\ORM\Mapping as ORM;

/**
 * FOSUser
 *
 * @ORM\Table(name="blogusers_f_o_s_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\blogusers\FOSUserRepository")
 */
class FOSUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="post", mappedBy="FOSUser")
     */
    private $post;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


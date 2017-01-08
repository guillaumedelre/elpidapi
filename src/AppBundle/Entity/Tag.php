<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An Tag
 *
 * @ORM\Entity
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={"groups"={"article_read", "tag_read"}},
 *          "denormalization_context"={"groups"={"tag_write"}},
 *          "force_eager"=false
 *      }
 * )
 */
class Tag extends CreativeWork
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"tag_read", "article_read"})
     */
    private $id;

    /**
     * @var Article[]|Collection|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Article", mappedBy="tags")
     * @Groups({"tag_read", "tag_write"})
     */
    private $articles;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Sets id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Article[]|ArrayCollection|Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article[]|ArrayCollection|Collection $articles
     * @return Tag
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }
}

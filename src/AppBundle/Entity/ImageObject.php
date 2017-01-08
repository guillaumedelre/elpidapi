<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An image file.
 *
 * @see http://schema.org/ImageObject Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(
 *     iri="http://schema.org/ImageObject",
 *     attributes={
 *          "normalization_context"={"groups"={"article_read", "image_read"}}
 *      }
 * )
 */
class ImageObject extends MediaObject
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"image_read"})
     */
    private $id;

    /**
     * @var string The caption for this object
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     * @ApiProperty(
     *     iri="https://schema.org/caption"
     * )
     * @Groups({"article_read", "image_read"})
     */
    private $caption;

    /**
     * @var Article[]|Collection|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Article", mappedBy="images")
     */
    private $articles;

    /**
     * ImageObject constructor.
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
     * Sets caption.
     *
     * @param string $caption
     *
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Gets caption.
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     * @return ImageObject
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }
}

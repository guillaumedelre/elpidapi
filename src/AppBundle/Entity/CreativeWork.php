<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The most generic kind of creative work, including books, movies, photographs, software programs, etc.
 *
 * @see http://schema.org/CreativeWork Documentation on Schema.org
 *
 * @ORM\MappedSuperclass
 */
abstract class CreativeWork
{
    /**
     * @var string Headline of the article
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     * @ApiProperty(
     *     iri="https://schema.org/headline"
     * )
     * @Groups({"article_read", "image_read", "tag_read", "tag_write"})
     */
    private $headline;

    /**
     * @var string Slug of the headline of the article
     *
     * @ORM\Column(unique=true)
     * @Assert\Type(type="string")
     * @Gedmo\Slug(fields={"headline"}, updatable=false)
     * @Groups({"article_read", "image_read", "tag_read"})
     */
    private $slug;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="boolean")
     * @Assert\NotNull
     * @Groups({"article_read", "image_read", "tag_read", "tag_write"})
     */
    private $published;

    /**
     * Sets headline.
     *
     * @param string $headline
     *
     * @return $this
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Gets headline.
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Gets slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets slug.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Sets published.
     *
     * @param bool $published
     *
     * @return $this
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Gets published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }
}

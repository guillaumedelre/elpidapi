<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An article, such as a news article or piece of investigative report. Newspapers and magazines have articles of many different types and this is intended to cover them all.\\n\\nSee also [blog post](http://blog.schema.org/2014/09/schemaorg-support-for-bibliographic\_2.html).
 *
 * @see http://schema.org/Article Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(
 *     iri="http://schema.org/Article",
 *     attributes={
 *          "normalization_context"={"groups"={"article_read", "tag_read"}},
 *          "denormalization_context"={"groups"={"tag_write"}},
 *          "force_eager"=false
 *      }
 * )
 */
class Article extends CreativeWork
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"article_read", "tag_write", "tag_read"})
     */
    private $id;

    /**
     * @var string The actual body of the article
     *
     * @ORM\Column(nullable=true, type="text")
     * @Assert\Type(type="string")
     * @ApiProperty(
     *     iri="https://schema.org/articleBody"
     * )
     * @Groups({"article_read"})
     */
    private $articleBody;

    /**
     * @var ImageObject[]|Collection|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ImageObject", inversedBy="articles")
     * @Groups({"article_read"})
     */
    private $images;

    /**
     * @var Tag[]|Collection|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="articles")
     * @Groups({"article_read"})
     */
    private $tags;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @Assert\Type(type="datetime")
     * @ORM\Column(type="datetime")
     * @Groups({"article_read"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @Assert\Type(type="datetime")
     * @ORM\Column(type="datetime")
     * @Groups({"article_read"})
     */
    protected $updatedAt;

    /**
     * Sets createdAt.
     *
     * @param  \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets updatedAt.
     *
     * @param  \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
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
     * Sets articleBody.
     *
     * @param string $articleBody
     *
     * @return $this
     */
    public function setArticleBody($articleBody)
    {
        $this->articleBody = $articleBody;

        return $this;
    }

    /**
     * Gets articleBody.
     *
     * @return string
     */
    public function getArticleBody()
    {
        return $this->articleBody;
    }

    /**
     * @return ImageObject[]|ArrayCollection|Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ImageObject[]|ArrayCollection|Collection $images
     * @return Article
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection|Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[]|ArrayCollection|Collection $tags
     * @return Article
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

}

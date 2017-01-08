<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A media object, such as an image, video, or audio object embedded in a web page or a downloadable dataset i.e. DataDownload. Note that a creative work may have many media objects associated with it on the same web page. For example, a page about a single song (MusicRecording) may have a music video (VideoObject), and a high and low bandwidth audio stream (2 AudioObject's).
 *
 * @see http://schema.org/MediaObject Documentation on Schema.org
 *
 * @ORM\MappedSuperclass
 */
abstract class MediaObject extends CreativeWork
{
    /**
     * @var string File size in (mega/kilo) bytes
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     * @ApiProperty(
     *     iri="https://schema.org/contentSize"
     * )
     * @Groups({"image_read"})
     */
    private $contentSize;

    /**
     * @var string Actual bytes of the media object, for example the image file or video file
     *
     * @ORM\Column(nullable=true)
     * @Assert\Url
     * @ApiProperty(
     *     iri="https://schema.org/contentUrl"
     * )
     * @Groups({"article_read", "image_read"})
     */
    private $contentUrl;

    /**
     * @var int The height of the item
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="integer")
     * @ApiProperty(
     *     iri="https://schema.org/height"
     * )
     * @Groups({"article_read", "image_read"})
     */
    private $height;

    /**
     * @var int The width of the item
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="integer")
     * @ApiProperty(
     *     iri="https://schema.org/width"
     * )
     * @Groups({"article_read", "image_read"})
     */
    private $width;

    /**
     * Sets contentSize.
     *
     * @param string $contentSize
     *
     * @return $this
     */
    public function setContentSize($contentSize)
    {
        $this->contentSize = $contentSize;

        return $this;
    }

    /**
     * Gets contentSize.
     *
     * @return string
     */
    public function getContentSize()
    {
        return $this->contentSize;
    }

    /**
     * Sets contentUrl.
     *
     * @param string $contentUrl
     *
     * @return $this
     */
    public function setContentUrl($contentUrl)
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    /**
     * Gets contentUrl.
     *
     * @return string
     */
    public function getContentUrl()
    {
        return $this->contentUrl;
    }

    /**
     * Sets height.
     *
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Gets height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets width.
     *
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Gets width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
}

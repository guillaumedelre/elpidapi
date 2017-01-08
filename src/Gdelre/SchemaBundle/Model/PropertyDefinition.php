<?php
namespace Gdelre\SchemaBundle\Model;

class PropertyDefinition
{
    /**
     * @var string|null
     */
    private $propertyName;

    /**
     * @var array|null
     */
    private $types;

    /**
     * @var array|null
     */
    private $annotations;

    /**
     * @var string|null
     */
    private $longDescription;

    /**
     * @var string|null
     */
    private $shortDescription;

    /**
     * @return null|string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param null|string $propertyName
     * @return PropertyDefinition
     */
    public function setPropertyName($propertyName = null)
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param array|null $types
     * @return PropertyDefinition
     */
    public function setTypes($types = null)
    {
        $this->types = $types;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param array|null $annotations
     * @return PropertyDefinition
     */
    public function setAnnotations($annotations = null)
    {
        $this->annotations = $annotations;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param null|string $longDescription
     * @return PropertyDefinition
     */
    public function setLongDescription($longDescription = null)
    {
        $this->longDescription = $longDescription;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param null|string $shortDescription
     * @return PropertyDefinition
     */
    public function setShortDescription($shortDescription = null)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

}
<?php
namespace Gdelre\SchemaBundle\Model;


class ClassDefinition
{
    /**
     * @var string|null
     */
    private $className;

    /**
     * @var PropertyDefinition[]|null
     */
    private $properties;

    /**
     * @return null|string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param null|string $className
     * @return ClassDefinition
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return PropertyDefinition[]|null
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param PropertyDefinition[]|null $properties
     * @return ClassDefinition
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @param PropertyDefinition $propertyDefinition
     * @return ClassDefinition
     */
    public function addProperty(PropertyDefinition $propertyDefinition)
    {
        $this->properties[] = $propertyDefinition;
        return $this;
    }

}
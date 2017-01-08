<?php
namespace Gdelre\SchemaBundle\Service;

use ApiPlatform\Core\Metadata\Property\Factory\AnnotationPropertyMetadataFactory;
use AppBundle\Entity\Article;
use AppBundle\Entity\ImageObject;
use AppBundle\Entity\Tag;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Gdelre\SchemaBundle\Model\ClassDefinition;
use Gdelre\SchemaBundle\Model\PropertyDefinition;
use Symfony\Component\PropertyInfo\PropertyAccessExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyDescriptionExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyListExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;

class SchemaExtractor
{
    const DOCTRINE_EXTRACTOR = 'doctrine';
    const REFLECTION_EXTRACTOR = 'reflection';
    const PHP_DOC_EXTRACTOR = 'php_doc';
    const API_RESOURCE_EXTRACTOR = 'api_resource';

    const AVAILABLE_EXTRACTORS = [
        self::DOCTRINE_EXTRACTOR,
        self::REFLECTION_EXTRACTOR,
        self::PHP_DOC_EXTRACTOR,
        self::API_RESOURCE_EXTRACTOR,
    ];

    /**
     * @var array
     */
    private $extractors;

    /**
     * @var PropertyListExtractorInterface[]
     */
    private $listExtractors;

    /**
     * @var PropertyTypeExtractorInterface[]
     */
    private $typeExtractors;

    /**
     * @var PropertyDescriptionExtractorInterface[]
     */
    private $descriptionExtractors;

    /**
     * @var PropertyAccessExtractorInterface[]
     */
    private $accessExtractors;

    /**
     * @var PropertyInfoExtractor
     */
    private $propertyInfo;

    /**
     * @param $extractors
     * @return SchemaExtractor
     */
    public function setExtractors($extractors)
    {
        foreach ($extractors as $name => $reference) {
            $this->extractors[] = $name;
            if ($this->isListExtractor($reference)) {
                $this->listExtractors[$name] = $reference;
            }
            if ($this->isTypeExtractor($reference)) {
                $this->typeExtractors[$name] = $reference;
            }
            if ($this->isDescriptionExtractor($reference)) {
                $this->descriptionExtractors[$name] = $reference;
            }
            if ($this->isAccessExtractors($reference)) {
                $this->accessExtractors[$name] = $reference;
            }
        }

        return $this;
    }

    private function isListExtractor($extractor)
    {
        return $extractor instanceof PropertyListExtractorInterface;
    }

    private function isTypeExtractor($extractor)
    {
        return $extractor instanceof PropertyTypeExtractorInterface;
    }

    private function isDescriptionExtractor($extractor)
    {
        return $extractor instanceof PropertyDescriptionExtractorInterface;
    }

    private function isAccessExtractors($extractor)
    {
        return $extractor instanceof PropertyAccessExtractorInterface;
    }

    /**
     * @return array
     */
    public function getExtractors(): array
    {
        return $this->extractors;
    }

    /**
     * @param string|null $extractorType
     * @return ArrayCollection
     * @throws \Exception
     */
    public function getSchema(string $extractorType = null)
    {
        $listExtractors = [];
        $typeExtractors = [];
        $descriptionExtractors = [];
        $accessExtractors = [];

        if (!in_array($extractorType, self::AVAILABLE_EXTRACTORS) && null !== $extractorType) {
            throw new \Exception(sprintf('Extractor %s not found. Available extractors are: %s.', $extractorType, implode(', ', $this->extractors)));
        }

        if (isset($this->listExtractors[$extractorType])) {
            $listExtractors[] = $this->listExtractors[$extractorType];
        } else {
            if (null !== $this->listExtractors) {
                $listExtractors = array_values($this->listExtractors);
            }
        }

        if (isset($this->typeExtractors[$extractorType])) {
            $typeExtractors[] = $this->typeExtractors[$extractorType];
        } else {
            if (null !== $this->typeExtractors) {
                $typeExtractors = array_values($this->typeExtractors);
            }
        }

        if (isset($this->descriptionExtractors[$extractorType])) {
            $descriptionExtractor[] = $this->descriptionExtractors[$extractorType];
        } else {
            if (null !== $this->descriptionExtractors) {
                $descriptionExtractors = array_values($this->descriptionExtractors);
            }
        }

        if (isset($this->accessExtractors[$extractorType])) {
            $accessExtractors[] = $this->accessExtractors[$extractorType];
        } else {
            if (null !== $this->accessExtractors) {
                $accessExtractors = array_values($this->accessExtractors);
            }
        }

        $this->propertyInfo = new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            $descriptionExtractors,
            $accessExtractors
        );

        return $this->getInformations();
    }

    /**
     * @return ArrayCollection
     */
    private function getInformations()
    {

        $schema = new ArrayCollection();

        $entities = [
            Article::class,
            ImageObject::class,
            Tag::class,
        ];

        foreach ($entities as $class) {
            $classDefinition = (new ClassDefinition())->setClassName($class);
            $properties = $this->propertyInfo->getProperties($class);
            if (is_array($properties)) {
                foreach ($properties as $property) {
                    $propertyDefinition = (new PropertyDefinition())
                        ->setPropertyName($property)
                        ->setTypes($this->propertyInfo->getTypes($class, $property))
                        ->setAnnotations($this->getAnnotations($class, $property))
                        ->setLongDescription($this->propertyInfo->getLongDescription($class, $property))
                        ->setShortDescription($this->propertyInfo->getShortDescription($class, $property));
                    $classDefinition->addProperty($propertyDefinition);
                }
                $schema->add($classDefinition);
            }
        }

        return $schema;
    }

    /**
     * @param string $class
     * @param string $property
     * @return array
     */
    private function getAnnotations(string $class, string $property)
    {
        $annotationReader = new AnnotationReader();

        $reflectionClass = $this->getReflectionClass($class);

        $return =  [];
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if ($property == $reflectionProperty->getName()) {
                $annotations = $annotationReader->getPropertyAnnotations($reflectionProperty);
                foreach ($annotations as $annotation) {
                    $reflectedClass = $this->getReflectionClass(get_class($annotation));
                    $return[$reflectedClass->getName()] = (array)$annotation;
                }
            }
        }

        return $return;
    }

    /**
     * @param string $class
     * @return \ReflectionClass
     */
    private function getReflectionClass(string $class): \ReflectionClass
    {
        return new \ReflectionClass($class);
    }
}
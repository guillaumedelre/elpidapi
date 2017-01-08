<?php
namespace Gdelre\SchemaBundle\Service\Extractor;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Annotations\AnnotationReader;
use Gdelre\SchemaBundle\Service\MetadataFactory\SerializerClassMetadataFactory;

class ApiResourceExtractor extends \Symfony\Component\PropertyInfo\Extractor\SerializerExtractor
{
    /**
     * @var SerializerClassMetadataFactory $serializerClassMetadataFactory
     */
    protected $serializerClassMetadataFactory;

    /**
     * SerializerExtractor constructor.
     * @param SerializerClassMetadataFactory $serializerClassMetadataFactory
     */
    public function __construct(SerializerClassMetadataFactory $serializerClassMetadataFactory)
    {
        $this->serializerClassMetadataFactory = $serializerClassMetadataFactory;

        parent::__construct($serializerClassMetadataFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties($class, array $context = array())
    {
        $reader = new AnnotationReader();

        $context['serializer_groups'] = [];

        try {
            $reflectionClass = new \ReflectionClass($class);
            $annotation = $reader->getClassAnnotation($reflectionClass, ApiResource::class);
            $context['serializer_groups'] = array_merge($context['serializer_groups'], $annotation->attributes['normalization_context']['groups'] ?? []);
            $context['serializer_groups'] = array_merge($context['serializer_groups'], $annotation->attributes['denormalization_context']['groups'] ?? []);
        } catch (\ReflectionException $e) {
            return;
        }

        if (!isset($context['serializer_groups']) || !is_array($context['serializer_groups'])) {
            return;
        }

        if (!$this->serializerClassMetadataFactory->getMetadataFor($class)) {
            return;
        }

        $properties = array();
        $serializerClassMetadata = $this->serializerClassMetadataFactory->getMetadataFor($class);

        foreach ($serializerClassMetadata->getAttributesMetadata() as $serializerAttributeMetadata) {
            if (count(array_intersect($context['serializer_groups'], $serializerAttributeMetadata->getGroups())) > 0) {
                $properties[] = $serializerAttributeMetadata->getName();
            }
        }

        return $properties;
    }
}
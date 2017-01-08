<?php
namespace Gdelre\SchemaBundle\Service\MetadataFactory;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class SerializerClassMetadataFactory extends ClassMetadataFactory
{
    /**
     * SerializerClassMetadataFactory constructor.
     */
    public function __construct()
    {
        parent::__construct(new AnnotationLoader(new AnnotationReader()));
    }
}
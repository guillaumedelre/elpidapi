<?php
namespace Gdelre\SchemaBundle\Service\Extractor;

use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory;

class DoctrineExtractor extends \Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor
{

    /**
     * DoctrineExtractor constructor.
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function __construct(ClassMetadataFactory $classMetadataFactory)
    {
        parent::__construct($classMetadataFactory);
    }
}
<?php

namespace Gdelre\SchemaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class GdelreSchemaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $schemaExtractor = $container->findDefinition('gdelre_schema.schema.extractor');
        $extractors = $container->findTaggedServiceIds('extractor');

        $data = [];
        foreach ($extractors as $serviceId => $params) {
            $data[reset($params)['type']] = new Reference($serviceId);
        }
        $schemaExtractor->addMethodCall('setExtractors', [$data]);
    }

}

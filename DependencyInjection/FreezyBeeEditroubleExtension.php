<?php

namespace FreezyBee\EditroubleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class FreezyBeeEditroubleExtension
 * @package FreezyBee\EditroubleBundle\DependencyInjection
 */
class FreezyBeeEditroubleExtension extends Extension
{
    /**
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('freezy_bee_editrouble.role', $config['role']);
        $container->setParameter('freezy_bee_editrouble.placeholder', $config['placeholder']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'freezy_bee_editrouble';
    }
}

<?php

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Behat\Context\ServiceContainer\ContextExtension;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class CustomExtension implements Extension
{
    /**
     * @return string
     */
    public function getConfigKey()
    {
        return 'initializer';
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = $container->register('initializer', \Feature\CustomInitializer::class);
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
    }

    /**
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
    }
}

return new CustomExtension;

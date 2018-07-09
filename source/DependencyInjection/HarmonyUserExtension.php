<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\UserBundle\DependencyInjection;

use Harmony\Bundle\UserBundle\Theme\ThemeInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Bundle container extension
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class HarmonyUserExtension extends Extension implements PrependExtensionInterface
{
    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new HarmonyUserConfiguration;
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));

        $loader->load('security.xml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new HarmonyUserConfiguration, $configs);

        $themeClass = $config['theme'];

        if ($themeClass !== null) {
            if (!class_exists($themeClass)) {
                throw new \LogicException(sprintf('The theme "%s" for HarmonyUserBundle could not be found.', $themeClass));
            }

            $reflectionClass = new \ReflectionClass($themeClass);
            $theme = $reflectionClass->newInstance();

            if (!$theme instanceof ThemeInterface) {
                throw new \LogicException(sprintf('The theme "%s" for HarmonyUserBundle is invalid.', $themeClass));
            }

            $path = $theme->getTemplatePath();

            $container->prependExtensionConfig('twig', [
                'paths' => [
                    $path => 'HarmonyUser',
                ],
            ]);
        }
    }
}

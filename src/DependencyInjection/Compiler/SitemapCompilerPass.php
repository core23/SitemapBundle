<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SitemapBundle\DependencyInjection\Compiler;

use Core23\SitemapBundle\Definition\DefintionManagerInterface;
use Core23\SitemapBundle\Sitemap\SitemapServiceManagerInterface;
use Core23\SitemapBundle\Sitemap\StaticSitemapService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class SitemapCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $serviceManager    = $container->findDefinition(SitemapServiceManagerInterface::class);
        $definitionManager = $container->findDefinition(DefintionManagerInterface::class);

        foreach ($container->findTaggedServiceIds('core23.sitemap') as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $definition->setPublic(true);

            $serviceManager->addMethodCall('addSitemap', [
                $id,
                new Reference($id),
            ]);

            $definitionManager->addMethodCall('addDefinition', [
                $id,
            ]);
        }

        $this->addStaticUrls($container, $definitionManager);
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition       $definitionManager
     */
    private function addStaticUrls(ContainerBuilder $container, Definition $definitionManager): void
    {
        foreach ($container->getParameter('core23_sitemap.static_urls') as $options) {
            $definitionManager->addMethodCall('addDefinition', [
                StaticSitemapService::class, $options,
            ]);
        }
    }
}

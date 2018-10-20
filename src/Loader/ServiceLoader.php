<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SitemapBundle\Loader;

use Core23\SitemapBundle\Definition\SitemapDefinition;
use Core23\SitemapBundle\Definition\SitemapDefinitionInterface;
use Core23\SitemapBundle\Exception\SitemapNotFoundException;

final class ServiceLoader implements SitemapLoaderInterface
{
    /**
     * @var string[]
     */
    private $types;

    /**
     * @param string[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configuration): SitemapDefinitionInterface
    {
        if (!\in_array($configuration['type'], $this->types)) {
            throw new SitemapNotFoundException(
                sprintf(
                    'The sitemap type "%s" does not exist',
                    $configuration['type']
                )
            );
        }

        return new SitemapDefinition($configuration['type'], $configuration['settings'] ?? []);
    }
}

SitemapBundle
=============
[![Latest Stable Version](https://poser.pugx.org/core23/sitemap-bundle/v/stable)](https://packagist.org/packages/core23/sitemap-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/sitemap-bundle/v/unstable)](https://packagist.org/packages/core23/sitemap-bundle)
[![License](https://poser.pugx.org/core23/sitemap-bundle/license)](https://packagist.org/packages/core23/sitemap-bundle)

[![Total Downloads](https://poser.pugx.org/core23/sitemap-bundle/downloads)](https://packagist.org/packages/core23/sitemap-bundle)
[![Monthly Downloads](https://poser.pugx.org/core23/sitemap-bundle/d/monthly)](https://packagist.org/packages/core23/sitemap-bundle)
[![Daily Downloads](https://poser.pugx.org/core23/sitemap-bundle/d/daily)](https://packagist.org/packages/core23/sitemap-bundle)

[![Build Status](https://travis-ci.org/core23/SitemapBundle.svg)](https://travis-ci.org/core23/SitemapBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/SitemapBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/core23/SitemapBundle)
[![Code Climate](https://codeclimate.com/github/core23/SitemapBundle/badges/gpa.svg)](https://codeclimate.com/github/core23/SitemapBundle)
[![Coverage Status](https://coveralls.io/repos/core23/SitemapBundle/badge.svg)](https://coveralls.io/r/core23/SitemapBundle)

This bundle provides some classes for an automatic **sitemap.xml** generation.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require core23/sitemap-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Core23\SitemapBundle\Core23SitemapBundle::class => ['all' => true],
];
```

### Configure the Bundle

Create a configuration file called `core23_sitemap.yaml`:

```yaml
# config/routes/core23_sitemap.yaml

core23_sitemap:
    resource: '@Core23SitemapBundle/Resources/config/routing/sitemap.yml'
    prefix: /
```

### Caching

If you want to use caching, you need to add the caching bundle:

```
composer require cache/cache-bundle
composer require cache/doctrine-adapter # If you want a doctrine cache
```

Create a configuration file called `core23_sitemap.yaml`:

```yaml
# config/packages/core23_sitemap.yaml

core23_sitemap:
    cache:
        service: 'cache.provider.sitemap_cache'

cache_adapter:
    providers:
        sitemap_cache:
            factory: 'cache.factory.doctrine_filesystem'
            options:
                directory: '%kernel.cache_dir%/cache'
```

### Add static entries

You can add static entries in your yaml config:

```yaml
# config/packages/core23_sitemap.yaml

core23_sitemap:
    static:
        - { url: 'http://example.com', priority: 75, changefreq: 'weekly' }
```

### Add a custom sitemap

If you want to create a custom sitemap, the only thing you have to do is to create a service that uses 
`Core23\SitemapBundle\Sitemap\SitemapServiceInterface` and tag the service with `core23.sitemap`.

```xml
    <service id="App\Sitemap\CustomSitemap">
      <tag name="core23.sitemap"/>
    </service>
```

## License

This bundle is under the [MIT license](LICENSE.md).

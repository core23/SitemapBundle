<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SitemapBundle\Tests\Action;

use Core23\SitemapBundle\Action\SitemapXMLAction;
use Core23\SitemapBundle\Generator\SitemapGeneratorInterface;
use PHPUnit\Framework\TestCase;

class SitemapXMLActionTest extends TestCase
{
    public function testExecute(): void
    {
        $generator = $this->prophesize(SitemapGeneratorInterface::class);
        $generator->toXML()
            ->willReturn('<xml></xml>')
        ;

        $action = new SitemapXMLAction($generator->reveal());

        $response = $action();

        $this->assertSame('text/xml', $response->headers->get('Content-Type'));
        $this->assertSame('<xml></xml>', $response->getContent());
    }
}
<?php

namespace Microserve\GeopluginApi\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Microserve\GeopluginApi\Service\Locator;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    /**
     * @var \Microserve\GeopluginApi\Service\Locator
     */
    private $locator;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $mock = new MockHandler([
            new Response(200, [], serialize([
                'geoplugin_countryCode' => 'GB',
                'geoplugin_countryName' => 'United Kingdom',
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->locator = new Locator($client);
    }

    /** @test */
    public function can_retrieve_the_country_code()
    {
        $this->assertSame('GB', $this->locator->execute()->getCountryCode());
    }
}

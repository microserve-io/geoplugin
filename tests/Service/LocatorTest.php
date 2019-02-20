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
    /** @test */
    public function can_retrieve_the_country_code()
    {
        $mock = new MockHandler([
            new Response(200, [], serialize([
                'geoplugin_countryCode' => 'GB',
                'geoplugin_countryName' => 'United Kingdom',
            ])),
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client(['handler' => $handler]);

        $result = new Locator($client);

        $this->assertSame('GB', $result->execute()->getCountryCode());
    }
}

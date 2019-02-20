<?php

namespace Microserve\GeopluginApi\Service;

use GuzzleHttp\Client;

class Locator
{
    /**
     * The base URL for the Geoplugin service.
     */
    const BASE_URL = 'http://www.geoplugin.net/php.gp';

    /**
     * The key for the country code.
     */
    const FIELD_COUNTRY_CODE = 'geoplugin_countryCode';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * The IP address to query.
     *
     * @var string
     */
    private $ipAddress;

    /**
     * The returned data.
     *
     * @var array
     */
    private $data = [];

    /**
     * Locator constructor.
     *
     * @param \GuzzleHttp\Client|NULL $client
     *   A Guzzle client.
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * Set the IP address.
     *
     * @param \Microserve\GeopluginApi\Service\string $ipAddress
     *   The IP address to set.
     *
     * @return self
     */
    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Execute the query.
     *
     * @return self
     */
    public function execute(): self
    {
        $response = $this->client->get(self::BASE_URL, [
            'query' => [
                'ip' => $this->ipAddress,
            ],
        ]);

        $this->data = unserialize($response->getBody()->getContents());

        return $this;
    }

    /**
     * Get the country code.
     *
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->data[self::FIELD_COUNTRY_CODE];
    }
}

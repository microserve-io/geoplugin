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
        $client = new Client();

        $response = $client->get(self::BASE_URL, [
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
        return $this->data['geoplugin_countryCode'];
    }
}

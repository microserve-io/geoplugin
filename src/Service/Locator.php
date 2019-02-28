<?php

namespace Microserve\Geoplugin\Service;

use GuzzleHttp\Client;

class Locator
{
    /**
     * The base URL for the Geoplugin service.
     */
    const BASE_URL = 'http://www.geoplugin.net/php.gp';

    /**
     * Constants for the field keys.
     */
    const FIELD_AREA_CODE = 'geoplugin_areaCode';
    const FIELD_CITY = 'geoplugin_city';
    const FIELD_CONTINENT_CODE = 'geoplugin_continentCode';
    const FIELD_CONTINENT_NAME = 'geoplugin_continentName';
    const FIELD_COUNTRY_CODE = 'geoplugin_countryCode';
    const FIELD_COUNTRY_NAME = 'geoplugin_countryName';
    const FIELD_CURRENCY_CODE = 'geoplugin_currencyCode';
    const FIELD_CURRENCY_CONVERTER = 'geoplugin_currencyConverter';
    const FIELD_CURRENCY_SYMBOL = 'geoplugin_currencySymbol';
    const FIELD_CURRENCY_SYMBOL_UTF8 = 'geoplugin_currencySymbol_UTF8';
    const FIELD_DMA_CODE = 'geoplugin_dmaCode';
    const FIELD_EU_VAT_RATE = 'geoplugin_euVATrate';
    const FIELD_IN_EU = 'geoplugin_inEU';
    const FIELD_IP_ADDRESS = 'geoplugin_request';
    const FIELD_LATITUDE = 'geoplugin_latitude';
    const FIELD_LOCATION_ACCURACY_RADIUS = 'geoplugin_locationAccuracyRadius';
    const FIELD_LONGITUDE = 'geoplugin_longitude';
    const FIELD_REGION = 'geoplugin_region';
    const FIELD_REGION_CODE = 'geoplugin_regionCode';
    const FIELD_REGION_NAME = 'geoplugin_regionName';
    const FIELD_TIMEZONE = 'geoplugin_timezone';

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
     * @param string $ipAddress
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

    /**
     * Get the request's IP address.
     *
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->data[self::FIELD_IP_ADDRESS];
    }

    /**
     * Return the data as an array.
     */
    public function toArray(): array
    {
        unset($this->data['geoplugin_delay']);
        unset($this->data['geoplugin_credit']);

        return $this->data;
    }
}

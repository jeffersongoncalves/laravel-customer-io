<?php

namespace JeffersonGoncalves\CustomerIo;

use JeffersonGoncalves\CustomerIo\Resources\Campaigns;
use JeffersonGoncalves\CustomerIo\Resources\Customers;
use JeffersonGoncalves\CustomerIo\Resources\Transactional;

/**
 * Entry point exposing one resource per Customer.io API group. Customer
 * profile writes/events go through the Track API (Basic Auth); campaigns
 * and transactional messaging go through the App API (Bearer token).
 */
class CustomerIo
{
    protected CustomerIoTrackClient $trackClient;

    protected CustomerIoAppClient $appClient;

    public function __construct(
        string $siteId,
        string $apiKey,
        string $appKey,
        string $trackUrl,
        string $appUrl,
    ) {
        $this->trackClient = new CustomerIoTrackClient($siteId, $apiKey, $trackUrl);
        $this->appClient = new CustomerIoAppClient($appKey, $appUrl);
    }

    public function customers(): Customers
    {
        return new Customers($this->trackClient, $this->appClient);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this->appClient);
    }

    public function transactional(): Transactional
    {
        return new Transactional($this->appClient);
    }
}

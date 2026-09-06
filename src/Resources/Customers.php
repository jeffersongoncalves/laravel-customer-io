<?php

namespace JeffersonGoncalves\CustomerIo\Resources;

use JeffersonGoncalves\CustomerIo\CustomerIoAppClient;
use JeffersonGoncalves\CustomerIo\CustomerIoTrackClient;

class Customers
{
    public function __construct(
        protected CustomerIoTrackClient $trackClient,
        protected CustomerIoAppClient $appClient,
    ) {}

    /** @param array<string, mixed> $attributes */
    public function identify(int|string $customerId, array $attributes = []): array
    {
        return $this->trackClient->put("/customers/{$customerId}", $attributes);
    }

    public function get(int|string $customerId): array
    {
        return $this->appClient->get("/customers/{$customerId}/attributes");
    }

    public function delete(int|string $customerId): array
    {
        return $this->trackClient->delete("/customers/{$customerId}");
    }

    /** @param array<string, mixed> $data */
    public function trackEvent(int|string $customerId, string $name, array $data = []): array
    {
        $body = ['name' => $name];

        if ($data !== []) {
            $body['data'] = $data;
        }

        return $this->trackClient->post("/customers/{$customerId}/events", $body);
    }
}

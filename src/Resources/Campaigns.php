<?php

namespace JeffersonGoncalves\CustomerIo\Resources;

use JeffersonGoncalves\CustomerIo\CustomerIoAppClient;

class Campaigns
{
    public function __construct(
        protected CustomerIoAppClient $client,
    ) {}

    public function list(): array
    {
        return $this->client->get('/campaigns');
    }

    public function get(int|string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}");
    }

    public function metrics(int|string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}/metrics");
    }

    /** @param array<string, mixed> $payload */
    public function trigger(int|string $campaignId, array $payload): array
    {
        return $this->client->post("/campaigns/{$campaignId}/triggers", $payload);
    }
}

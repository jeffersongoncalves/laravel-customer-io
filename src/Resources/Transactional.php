<?php

namespace JeffersonGoncalves\CustomerIo\Resources;

use JeffersonGoncalves\CustomerIo\CustomerIoAppClient;

class Transactional
{
    public function __construct(
        protected CustomerIoAppClient $client,
    ) {}

    /** @param array<string, mixed> $payload */
    public function sendEmail(array $payload): array
    {
        return $this->client->post('/send/email', $payload);
    }
}

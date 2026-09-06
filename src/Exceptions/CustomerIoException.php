<?php

namespace JeffersonGoncalves\CustomerIo\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class CustomerIoException extends RuntimeException
{
    /** @var array<string, mixed> */
    protected array $errorBody = [];

    public static function fromResponse(Response $response): self
    {
        $body = (array) ($response->json() ?? []);

        $meta = is_array($body['meta'] ?? null) ? $body['meta'] : [];
        $errors = is_array($body['errors'] ?? null) ? $body['errors'] : [];
        $firstError = is_array($errors[0] ?? null) ? $errors[0] : [];

        $message = $meta['error']
            ?? $firstError['message']
            ?? "Customer.io API error (HTTP {$response->status()}).";

        $exception = new self((string) $message, $response->status());
        $exception->errorBody = $body;

        return $exception;
    }

    /** @return array<string, mixed> */
    public function errorBody(): array
    {
        return $this->errorBody;
    }
}

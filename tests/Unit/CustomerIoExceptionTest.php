<?php

use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\Response as HttpResponse;
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;

function fakeCioResponse(int $status, array $body): Response
{
    $psr = new GuzzleHttp\Psr7\Response($status, [], json_encode($body));

    return new HttpResponse($psr);
}

it('builds the exception message from the response "meta.error" field', function () {
    $response = fakeCioResponse(400, ['meta' => ['error' => 'invalid email']]);

    $exception = CustomerIoException::fromResponse($response);

    expect($exception->getMessage())->toBe('invalid email')
        ->and($exception->getCode())->toBe(400)
        ->and($exception->errorBody())->toBe(['meta' => ['error' => 'invalid email']]);
});

it('falls back to the first error message when "meta.error" is missing', function () {
    $response = fakeCioResponse(404, ['errors' => [['message' => 'campaign not found']]]);

    $exception = CustomerIoException::fromResponse($response);

    expect($exception->getMessage())->toBe('campaign not found');
});

it('falls back to a generic message when the body has no known error keys', function () {
    $response = fakeCioResponse(500, []);

    $exception = CustomerIoException::fromResponse($response);

    expect($exception->getMessage())->toBe('Customer.io API error (HTTP 500).');
});

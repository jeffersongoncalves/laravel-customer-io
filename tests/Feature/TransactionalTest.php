<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;
use JeffersonGoncalves\CustomerIo\Facades\CustomerIo;

it('sends a transactional email', function () {
    Http::fake(['api.customer.io/v1/send/email' => Http::response(['delivery_id' => 'abc123', 'queued_at' => 12345])]);

    $result = CustomerIo::transactional()->sendEmail([
        'transactional_message_id' => '5',
        'to' => 'jane@example.com',
        'identifiers' => ['id' => '123'],
        'message_data' => ['name' => 'Jane'],
    ]);

    expect($result['delivery_id'])->toBe('abc123');
    Http::assertSent(fn ($request) => $request['to'] === 'jane@example.com'
        && $request['message_data']['name'] === 'Jane');
});

it('throws on a failed transactional send', function () {
    Http::fake(['api.customer.io/v1/send/email' => Http::response(['meta' => ['error' => 'message not found']], 400)]);

    expect(fn () => CustomerIo::transactional()->sendEmail(['transactional_message_id' => '999', 'to' => 'jane@example.com']))
        ->toThrow(CustomerIoException::class, 'message not found');
});

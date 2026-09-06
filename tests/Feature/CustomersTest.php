<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;
use JeffersonGoncalves\CustomerIo\Facades\CustomerIo;

it('identifies a customer', function () {
    Http::fake(['track.customer.io/*' => Http::response(['id' => '123'])]);

    $result = CustomerIo::customers()->identify(123, ['email' => 'jane@example.com']);

    expect($result['id'])->toBe('123');
    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), 'track.customer.io/api/v1/customers/123')
        && $request['email'] === 'jane@example.com');
});

it('gets a customer', function () {
    Http::fake(['api.customer.io/*' => Http::response(['customer' => ['id' => '123', 'attributes' => ['email' => 'jane@example.com']]])]);

    $result = CustomerIo::customers()->get(123);

    expect($result['customer']['attributes']['email'])->toBe('jane@example.com');
    Http::assertSent(fn ($request) => str_contains($request->url(), 'api.customer.io/v1/customers/123/attributes'));
});

it('deletes a customer', function () {
    Http::fake(['track.customer.io/*' => Http::response([])]);

    CustomerIo::customers()->delete(123);

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), 'track.customer.io/api/v1/customers/123'));
});

it('tracks a customer event', function () {
    Http::fake(['track.customer.io/*' => Http::response([])]);

    CustomerIo::customers()->trackEvent(123, 'purchase', ['amount' => 42]);

    Http::assertSent(fn ($request) => str_contains($request->url(), '/customers/123/events')
        && $request['name'] === 'purchase'
        && $request['data']['amount'] === 42);
});

it('throws on a failed identify call', function () {
    Http::fake(['track.customer.io/*' => Http::response(['meta' => ['error' => 'invalid email']], 400)]);

    expect(fn () => CustomerIo::customers()->identify(123, ['email' => 'not-an-email']))
        ->toThrow(CustomerIoException::class, 'invalid email');
});

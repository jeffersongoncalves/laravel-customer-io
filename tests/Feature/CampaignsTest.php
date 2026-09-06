<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;
use JeffersonGoncalves\CustomerIo\Facades\CustomerIo;

it('lists campaigns', function () {
    Http::fake(['api.customer.io/v1/campaigns' => Http::response(['campaigns' => [['id' => 1, 'name' => 'Welcome']]])]);

    $result = CustomerIo::campaigns()->list();

    expect($result['campaigns'][0]['name'])->toBe('Welcome');
});

it('gets a single campaign', function () {
    Http::fake(['api.customer.io/v1/campaigns/1' => Http::response(['campaign' => ['id' => 1]])]);

    $result = CustomerIo::campaigns()->get(1);

    expect($result['campaign']['id'])->toBe(1);
});

it('gets campaign metrics', function () {
    Http::fake(['api.customer.io/v1/campaigns/1/metrics' => Http::response(['metric' => ['sent' => 100]])]);

    $result = CustomerIo::campaigns()->metrics(1);

    expect($result['metric']['sent'])->toBe(100);
});

it('triggers a campaign', function () {
    Http::fake(['api.customer.io/v1/campaigns/1/triggers' => Http::response(['id' => 'abc123'])]);

    $result = CustomerIo::campaigns()->trigger(1, ['emails' => ['jane@example.com'], 'data' => ['coupon' => 'SAVE10']]);

    expect($result['id'])->toBe('abc123');
    Http::assertSent(fn ($request) => $request['emails'][0] === 'jane@example.com');
});

it('throws on a failed campaign trigger', function () {
    Http::fake(['api.customer.io/v1/campaigns/1/triggers' => Http::response(['errors' => [['message' => 'campaign not found']]], 404)]);

    expect(fn () => CustomerIo::campaigns()->trigger(1, []))
        ->toThrow(CustomerIoException::class, 'campaign not found');
});

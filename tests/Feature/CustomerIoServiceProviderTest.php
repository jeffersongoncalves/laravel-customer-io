<?php

use JeffersonGoncalves\CustomerIo\CustomerIo as CustomerIoManager;
use JeffersonGoncalves\CustomerIo\Facades\CustomerIo;

it('merges the default config', function () {
    expect(config('customer-io.track_url'))->toBe('https://track.customer.io/api/v1')
        ->and(config('customer-io.app_url'))->toBe('https://api.customer.io/v1');
});

it('resolves the facade to the manager singleton', function () {
    expect(CustomerIo::getFacadeRoot())->toBeInstanceOf(CustomerIoManager::class);
});

it('always resolves the same manager instance', function () {
    expect(app(CustomerIoManager::class))->toBe(app(CustomerIoManager::class));
});

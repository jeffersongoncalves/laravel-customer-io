<?php

namespace JeffersonGoncalves\CustomerIo\Tests;

use JeffersonGoncalves\CustomerIo\CustomerIoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            CustomerIoServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('customer-io.site_id', 'test-site-id');
        $app['config']->set('customer-io.api_key', 'test-api-key');
        $app['config']->set('customer-io.app_key', 'test-app-key');
        $app['config']->set('customer-io.track_url', 'https://track.customer.io/api/v1');
        $app['config']->set('customer-io.app_url', 'https://api.customer.io/v1');
    }
}

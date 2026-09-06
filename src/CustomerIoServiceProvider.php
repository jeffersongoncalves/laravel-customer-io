<?php

namespace JeffersonGoncalves\CustomerIo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CustomerIoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('customer-io')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(CustomerIo::class, function () {
            return new CustomerIo(
                (string) config('customer-io.site_id'),
                (string) config('customer-io.api_key'),
                (string) config('customer-io.app_key'),
                (string) config('customer-io.track_url'),
                (string) config('customer-io.app_url'),
            );
        });
    }
}

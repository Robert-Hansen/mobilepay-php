<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay;

use Illuminate\Container\Container;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MobilePayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mobilepay-php')
            ->hasConfigFile('mobilepay');
    }

    public function packageRegistered()
    {
        $this->app->singleton(
            abstract:'MobilePay',
            concrete: fn(Container $container) => (new MobilePayManager($container['config']))->make(),
        );
    }
}

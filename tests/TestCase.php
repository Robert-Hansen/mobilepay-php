<?php

namespace RobertHansen\MobilePay\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RobertHansen\MobilePay\Facades\MobilePay;
use RobertHansen\MobilePay\MobilePayServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MobilePayServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('mobilepay', [
            'uri' => 'https://mobilepay.test',
            'api_key' => 'test',
            'client_id' => 'test',
            'timeout' => 10,
        ]);
    }

    protected function getPackageAliases($app): array
    {
        return [
            'MobilePay' => MobilePay::class,
        ];
    }
}

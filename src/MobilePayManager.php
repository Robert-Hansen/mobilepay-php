<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay;

use Illuminate\Contracts\Config\Repository;
use RobertHansen\MobilePay\Client\Factory;

class MobilePayManager
{
    protected array $config;

    public function __construct(Repository $config)
    {
        $this->config = $config['mobilepay'];
    }

    public function make(): Factory
    {
        return new Factory(
            baseUri: strval($this->config['uri']),
            apiKey: strval($this->config['api_key']),
            clientId: strval($this->config['client_id']),
            timeout: intval($this->config['timeout']),
            retryTimes: intval(data_get($this->config, 'retry.times')),
            retrySleep: intval(data_get($this->config, 'retry.sleep')),
        );
    }
}

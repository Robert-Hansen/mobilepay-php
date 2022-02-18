<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Contracts;

interface ResourceContract
{
    /**
     * Retrieve the built Service from the Resource.
     *
     * @return ServiceContract
     */
    public function service(): ServiceContract;
}

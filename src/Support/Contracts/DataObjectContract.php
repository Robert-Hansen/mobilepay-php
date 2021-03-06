<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Contracts;

interface DataObjectContract
{
    /**
     * Return the Data Object back as an array representation.
     *
     * @return array
     */
    public function toArray(): array;
}

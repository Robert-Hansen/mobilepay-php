<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Refund\Filters;

use Carbon\CarbonImmutable;
use GuzzleHttp\Psr7\Query;
use Illuminate\Contracts\Support\Arrayable;

final class ListOptionsFilter implements Arrayable
{
    public function __construct(
        public readonly int $pageSize = 10,
        public readonly int $pageNumber = 1,
        public readonly string|null $paymentId = null,
        public readonly string|null $paymentPointId = null,
        public readonly CarbonImmutable|null $createdBefore = null,
        public readonly CarbonImmutable|null $createdAfter = null,
    ) {
    }

    public function toQuery(): string
    {
        return Query::build(array_filter($this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'pageSize' => $this->pageSize,
            'pageNumber' => $this->pageNumber,
            'paymentId' => $this->paymentId,
            'paymentPointId' => $this->paymentPointId,
            'createdBefore' => $this->createdBefore,
            'createdAfter' => $this->createdAfter,
        ];
    }
}

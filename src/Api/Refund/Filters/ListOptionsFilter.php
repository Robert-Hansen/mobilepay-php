<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Refund\Filters;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Query;
use Illuminate\Contracts\Support\Arrayable;
use RobertHansen\MobilePay\Support\Attributes\Numbers\GreaterThan;
use RobertHansen\MobilePay\Support\Attributes\Numbers\NumberBetween;
use RobertHansen\MobilePay\Support\Attributes\Strings\Uuid;
use Spatie\DataTransferObject\DataTransferObject;

final class ListOptionsFilter extends DataTransferObject implements Arrayable
{
    /**
     * The number of payment refunds per page. The range is 1 to 1000.
     */
    #[NumberBetween(min: 1, max: 1000)]
    public int $pageSize = 10;

    /**
     * The page number.
     */
    #[GreaterThan(value: 1)]
    public int $pageNumber = 1;

    /**
     * The ID of the payment.
     */
    #[Uuid(nullable: true)]
    public string|null $paymentId = null;

    /**
     * The payment point on which the payment was initiated.
     */
    #[Uuid(nullable: true)]
    public string|null $paymentPointId = null;

    /**
     * Filter refunds by CreatedOn property.
     */
    public DateTimeImmutable|null $createdBefore = null;

    /**
     * Filter refunds by CreatedOn property.
     */
    public DateTimeImmutable|null $createdAfter = null;

    /**
     * Build filter url.
     */
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
            'createdBefore' => $this->createdBefore?->format('Y-m-d\TH:i'),
            'createdAfter' => $this->createdAfter?->format('Y-m-d\TH:i'),
        ];
    }
}

<?php

namespace RobertHansen\MobilePay\Refund\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Contracts\ResourceContract;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Refund\DataObjects\Refund;
use RobertHansen\MobilePay\Refund\Factories\RefundFactory;
use RobertHansen\MobilePay\Refund\Filters\ListOptionsFilter;

class RefundResource implements ResourceContract
{
    public function __construct(
        private readonly ServiceContract $service,
    ) {
    }

    public function service(): ServiceContract
    {
        return $this->service;
    }

    /**
     * @throws MobilePayRequestException
     */
    public function list(ListOptionsFilter $listOptions = new ListOptionsFilter()): Collection
    {
        $listOptions = $listOptions->toQuery();

        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/refunds?$listOptions");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return collect($response->json('refunds'))->map(fn (array $refund) => RefundFactory::make(
            attributes: $refund,
        ));
    }

    /**
     * @throws MobilePayRequestException
     */
    public function get(string $refundId): Refund
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/refunds/$refundId");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return RefundFactory::make(
            attributes: (array) $response->json(),
        );
    }
}

<?php

namespace RobertHansen\MobilePay\Api\Refund\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Api\Refund\DataObjects\Refund;
use RobertHansen\MobilePay\Api\Refund\Factories\RefundFactory;
use RobertHansen\MobilePay\Api\Refund\Filters\ListOptionsFilter;
use RobertHansen\MobilePay\Api\Refund\Requests\CreateRefundRequest;
use RobertHansen\MobilePay\Support\Contracts\ResourceContract;
use RobertHansen\MobilePay\Support\Contracts\ServiceContract;
use RobertHansen\MobilePay\Support\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Support\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Support\Exceptions\UnauthorizedException;
use RobertHansen\MobilePay\Support\Resources\AbstractResource;

class RefundResource extends AbstractResource implements ResourceContract
{
    private string $resource = 'v1/refunds';

    public function __construct(
        private readonly ServiceContract $service,
    ) {
    }

    public function service(): ServiceContract
    {
        return $this->service;
    }

    /**
     * Gets a list of all merchant refunds.
     *
     * @param ListOptionsFilter $listOptions
     *
     * @return Collection
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function get(ListOptionsFilter $listOptions = new ListOptionsFilter()): Collection
    {
        $listOptions = $listOptions->toQuery();

        $request = $this->service()->makeRequest();
        $response = $request->get(url: "$this->resource?$listOptions");

        $this->handleFailed($response);

        return collect($response->json('refunds'))->map(fn (array $refund) => RefundFactory::make(
            attributes: $refund,
        ));
    }

    /**
     * Find a single refund by its ID.
     *
     * @param string $refundId
     *
     * @return Refund
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function find(string $refundId): Refund
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "$this->resource/$refundId");

        $this->handleFailed($response);

        return RefundFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Issue a new refund.
     *
     * @param CreateRefundRequest $requestBody
     *
     * @return Refund
     *
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    public function create(CreateRefundRequest $requestBody): Refund
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: $this->resource, data: $requestBody->toRequest());

        $this->handleFailed($response);

        return RefundFactory::make(
            attributes: (array) $response->json(),
        );
    }
}

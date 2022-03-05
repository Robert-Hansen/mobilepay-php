<?php

namespace RobertHansen\MobilePay\Api\Payment\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Api\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Api\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Api\Payment\Factories\CreatePaymentFactory;
use RobertHansen\MobilePay\Api\Payment\Factories\PaymentFactory;
use RobertHansen\MobilePay\Api\Payment\Requests\CapturePaymentRequest;
use RobertHansen\MobilePay\Api\Payment\Requests\CreatePaymentRequest;
use RobertHansen\MobilePay\Support\Contracts\ResourceContract;
use RobertHansen\MobilePay\Support\Contracts\ServiceContract;
use RobertHansen\MobilePay\Support\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Support\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Support\Exceptions\UnauthorizedException;
use RobertHansen\MobilePay\Support\Resources\AbstractResource;

class PaymentResource extends AbstractResource implements ResourceContract
{
    private string $resource = 'v1/payments';

    public function __construct(
        private readonly ServiceContract $service,
    ) {
    }

    public function service(): ServiceContract
    {
        return $this->service;
    }

    /**
     * Gets a list of all merchant payments.
     *
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    public function get(): Collection
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: $this->resource);

        $this->handleFailed($response);

        return collect($response->json('payments'))->map(fn (array $payment) => PaymentFactory::make(
            attributes: $payment,
        ));
    }

    /**
     * Find a single payment by its ID.
     *
     * @param string $paymentId
     *
     * @return Payment
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function find(string $paymentId): Payment
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "$this->resource/$paymentId");

        $this->handleFailed($response);

        return PaymentFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Create a new payment.
     *
     * @param CreatePaymentRequest $requestBody
     *
     * @return CreatePayment
     *
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    public function create(CreatePaymentRequest $requestBody): CreatePayment
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: $this->resource, data: $requestBody->toRequest());

        $this->handleFailed($response);

        return CreatePaymentFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Capture a payment by its ID.
     *
     * @param string $paymentId
     * @param CapturePaymentRequest $requestBody
     *
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    public function capture(string $paymentId, CapturePaymentRequest $requestBody): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "$this->resource/$paymentId/capture", data: $requestBody->toRequest());

        $this->handleFailed($response);
    }

    /**
     * Cancel a payment by its ID.
     *
     * @param string $paymentId
     *
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    public function cancel(string $paymentId): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "$this->resource/$paymentId/cancel");

        $this->handleFailed($response);
    }
}

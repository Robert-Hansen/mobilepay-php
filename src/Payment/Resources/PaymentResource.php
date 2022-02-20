<?php

namespace RobertHansen\MobilePay\Payment\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Contracts\ResourceContract;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Enums\Http\StatusCode;
use RobertHansen\MobilePay\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Exceptions\UnauthorizedException;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Payment\Factories\CreatePaymentFactory;
use RobertHansen\MobilePay\Payment\Factories\PaymentFactory;
use RobertHansen\MobilePay\Payment\Requests\CapturePaymentRequest;
use RobertHansen\MobilePay\Payment\Requests\CreatePaymentRequest;

class PaymentResource implements ResourceContract
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
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
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

    /**
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    private function handleFailed(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        match (StatusCode::tryFrom($response->status())) {
            StatusCode::HTTP_UNAUTHORIZED => throw new UnauthorizedException(response: $response),
            StatusCode::HTTP_BAD_REQUEST => throw new BadRequestException(response: $response),
            StatusCode::HTTP_CONFLICT => throw new ConflictRequestException(response: $response),
            StatusCode::HTTP_INTERNAL_SERVER_ERROR => throw new ServerInternalErrorException(response: $response),
            default => throw new MobilePayRequestException(response: $response),
        };
    }
}

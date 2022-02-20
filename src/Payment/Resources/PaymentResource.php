<?php

namespace RobertHansen\MobilePay\Payment\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Contracts\ResourceContract;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Payment\Factories\CreatePaymentFactory;
use RobertHansen\MobilePay\Payment\Factories\PaymentFactory;
use RobertHansen\MobilePay\Payment\Requests\CapturePaymentRequest;
use RobertHansen\MobilePay\Payment\Requests\CreatePaymentRequest;

class PaymentResource implements ResourceContract
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
    public function list(): Collection
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/payments");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return collect($response->json('payments'))->map(fn (array $payment) => PaymentFactory::make(
            attributes: $payment,
        ));
    }

    /**
     * @throws MobilePayRequestException
     */
    public function get(string $paymentId): Payment
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/payments/$paymentId");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return PaymentFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * @throws MobilePayRequestException
     */
    public function create(CreatePaymentRequest $requestBody): CreatePayment
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "v1/payments", data: $requestBody->toRequest());

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return CreatePaymentFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * @throws MobilePayRequestException
     */
    public function capture(string $paymentId, CapturePaymentRequest $requestBody): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "v1/payments/$paymentId/capture", data: $requestBody->toRequest());

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }
    }

    /**
     * @throws MobilePayRequestException
     */
    public function cancel(string $paymentId): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "v1/payments/$paymentId/cancel");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }
    }
}

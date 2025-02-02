<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Http\Controllers;

use Modules\Invoices\Application\UseCase\Commands\CreateInvoiceCommand;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Invoices\Presentation\Http\Requests\CreateInvoiceRequest;
use Modules\Shared\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class CreateInvoiceController
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    public function __invoke(CreateInvoiceRequest $request): JsonResponse
    {
        try {
            $command = new CreateInvoiceCommand(
                customerName: $request->input('customer_name'),
                customerEmail: $request->input('customer_email'),
                productLines: $request->input('invoice_product_lines'),
            );
            $this->commandBus->dispatch($command);

            return new JsonResponse(status: Response::HTTP_CREATED);
        } catch (DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_FAILED_DEPENDENCY);
        } catch (\Throwable) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
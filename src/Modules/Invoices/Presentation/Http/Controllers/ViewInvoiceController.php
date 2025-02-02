<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Http\Controllers;

use Modules\Invoices\Application\UseCase\Queries\ViewInvoiceQuery;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Shared\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class ViewInvoiceController
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        try {
            $invoice = new ViewInvoiceQuery($id);

            $invoiceViewModel = $this->queryBus->ask($invoice);

            return new JsonResponse($invoiceViewModel, Response::HTTP_OK);
        } catch (DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_FAILED_DEPENDENCY);
        } catch (\Throwable) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Http\Controllers;

use Modules\Invoices\Application\UseCase\Commands\SendInvoiceCommand;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Shared\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class SendInvoiceController
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        try {
            $command = new SendInvoiceCommand($id);

            $this->commandBus->dispatch($command);

            return new JsonResponse(status: Response::HTTP_OK);
        } catch (DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_FAILED_DEPENDENCY);
        } catch (\Throwable) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
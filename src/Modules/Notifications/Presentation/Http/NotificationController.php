<?php

declare(strict_types=1);

namespace Modules\Notifications\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Invoices\Domain\Exceptions\DomainException;
use Modules\Notifications\Application\Services\NotificationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class NotificationController
{
    public function __construct(
        private NotificationService $notificationService,
    ) {}

    public function hook(string $action, string $reference): JsonResponse
    {
        try {
            match ($action) {
                'delivered' => $this->notificationService->delivered(reference: $reference),
                default => throw new NotFoundHttpException(),
            };

            return new JsonResponse(status: Response::HTTP_OK);
        } catch (DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_FAILED_DEPENDENCY);
        } catch (NotFoundHttpException) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        } catch (\Throwable) {
            return new JsonResponse(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

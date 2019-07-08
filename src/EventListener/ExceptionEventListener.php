<?php declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ExceptionEventListener
 *
 * @author  Serhii Kondratiuk <serhii.kondratiuk@cosmonova.net>
 * @package App\EventListener
 * Cosmonova | Research & Development
 */
class ExceptionEventListener
{
    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * ExceptionEventListener constructor.
     *
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @param \Psr\Log\LoggerInterface                          $logger
     */
    public function __construct(
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->logger     = $logger;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $content = ['error' => $exception->getMessage()];

            $response->setContent($this->serializer->serialize($content, 'json'));
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($this->serializer->serialize(['error' => 'Server error'], 'json'));
            $this->logger->error($exception->getMessage(),
                [
                    'app'   => 'connections',
                    'trace' => $exception->getTraceAsString()
                ]);
        }

        $event->setResponse($response);
    }
}

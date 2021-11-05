<?php


namespace CptBurke\Application\SymfonyMessenger\Domain;


use CptBurke\Application\Domain\DomainEvent;
use CptBurke\Application\Domain\DomainEventBus;
use Exception;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;


class InMemoryMessengerDomainEventBus implements DomainEventBus
{

    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param DomainEvent ...$es
     * @throws Exception
     */
    public function dispatch(DomainEvent ...$es): void
    {
        foreach ($es as $e) {
            $res = $this->bus->dispatch($e);
            $handled = $res->last(HandledStamp::class);
            if ($handled === null) {
                throw new Exception('domain events must be handled synchronously.');
            }
        }
    }

}

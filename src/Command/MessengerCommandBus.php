<?php


namespace CptBurke\Application\SymfonyMessenger\Command;


use CptBurke\Application\Command\Command;
use CptBurke\Application\Command\CommandBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Throwable;


class MessengerCommandBus implements CommandBus
{

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Command $c
     * @param StampInterface[] $context
     * @return mixed
     * @throws Throwable
     */
    public function dispatch(Command $c, array $context = []): mixed
    {
        try {
            $envelope = $this->bus->dispatch(new Envelope($c, $context));

            $handled = $envelope->last(HandledStamp::class);
            if ($handled instanceof HandledStamp) {
                return $handled->getResult();
            }
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }

        return null;
    }

}

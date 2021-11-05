<?php


namespace CptBurke\Application\SymfonyMessenger\Query;


use Exception;
use CptBurke\Application\Query\Query;
use CptBurke\Application\Query\QueryBus;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;


class InMemoryMessengerQueryBus implements QueryBus
{

    private MessageBus $bus;

    /**
     * @param MessageBus $bus
     */
    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Query $q
     * @return mixed
     * @throws Exception
     */
    public function ask(Query $q): mixed
    {
        $envelope = $this->bus->dispatch($q);

        $handled = $envelope->last(HandledStamp::class);
        if ($handled instanceof HandledStamp) {
            return $handled->getResult();
        }

        throw new Exception('query must be handled synchronously.');
    }

}

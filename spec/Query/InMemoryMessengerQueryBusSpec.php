<?php


namespace spec\CptBurke\Application\SymfonyMessenger\Query;


use CptBurke\Application\Query\Query;
use CptBurke\Application\Query\QueryBus;
use CptBurke\Application\SymfonyMessenger\Query\InMemoryMessengerQueryBus;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;


class InMemoryMessengerQueryBusSpec extends ObjectBehavior
{

    public function it_is_initializable(MessageBus $bus): void
    {
        $this->beConstructedWith($bus);
        $this->shouldImplement(QueryBus::class);
        $this->shouldHaveType(InMemoryMessengerQueryBus::class);
    }

    public function it_must_be_handled_synchronously(MessageBus $bus): void
    {
        $query = new class implements Query {};
        $bus->dispatch($query)
            ->willReturn(new Envelope($query))
        ;

        $this->beConstructedWith($bus);
        $this->shouldThrow(new \Exception('query must be handled synchronously.'))
            ->during('ask', [$query])
        ;
    }

    public function it_returns_result(MessageBus $bus): void
    {
        $query = new class implements Query {};
        $bus->dispatch($query)
            ->willReturn(new Envelope($query, [new HandledStamp('query_result', 'TestHandler')]))
        ;

        $this->beConstructedWith($bus);
        $this->ask($query)->shouldReturn('query_result');
    }

}

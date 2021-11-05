<?php


namespace spec\CptBurke\Application\SymfonyMessenger\Domain;


use CptBurke\Application\Domain\DomainEvent;
use CptBurke\Application\Domain\DomainEventBus;
use CptBurke\Application\SymfonyMessenger\Domain\InMemoryMessengerDomainEventBus;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;


class InMemoryMessengerDomainEventBusSpec extends ObjectBehavior
{

    public function it_is_initializable(MessageBus $bus): void
    {
        $this->beConstructedWith($bus);
        $this->shouldImplement(DomainEventBus::class);
        $this->shouldHaveType(InMemoryMessengerDomainEventBus::class);
    }

    public function it_accepts_multiple_events(MessageBus $bus): void
    {
        $event1 = new class implements DomainEvent {};
        $event2 = new class implements DomainEvent {};
        $bus->dispatch($event1)
            ->willReturn(new Envelope($event1, [new HandledStamp('res_1', 'TestHandler')]))
            ->shouldBeCalledOnce()
        ;
        $bus->dispatch($event2)
            ->willReturn(new Envelope($event2, [new HandledStamp('res_2', 'TestHandler')]))
            ->shouldBeCalledOnce()
        ;

        $this->beConstructedWith($bus);
        $this->dispatch($event1, $event2);
    }

    public function it_handles_messages_directly(MessageBus $bus): void
    {
        $event = new class implements DomainEvent {};
        $bus->dispatch($event)
            ->willReturn(new Envelope($event));

        $this->beConstructedWith($bus);
        $this->shouldThrow(new \Exception('domain events must be handled synchronously.'))
            ->during('dispatch', [$event]);
    }

}

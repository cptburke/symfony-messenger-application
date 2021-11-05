<?php


namespace spec\CptBurke\Application\SymfonyMessenger\Event;


use CptBurke\Application\Event\ApplicationEvent;
use CptBurke\Application\Event\ApplicationEventBus;
use CptBurke\Application\SymfonyMessenger\Event\MessengerApplicationEventBus;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;


class MessengerApplicationEventBusSpec extends ObjectBehavior
{

    public function it_is_initializable(MessageBusInterface $bus): void
    {
        $this->beConstructedWith($bus);
        $this->shouldImplement(ApplicationEventBus::class);
        $this->shouldHaveType(MessengerApplicationEventBus::class);
    }

    public function it_accepts_multiple_events(MessageBusInterface $bus): void
    {
        $event1 = new class implements ApplicationEvent {};
        $event2 = new class implements ApplicationEvent {};
        $bus->dispatch($event1)
            ->willReturn(new Envelope($event1))
            ->shouldBeCalledOnce();
        $bus-> dispatch($event2)
            ->willReturn(new Envelope($event2))
            ->shouldBeCalledOnce();

        $this->beConstructedWith($bus);
        $this->dispatch($event1, $event2);
    }

}

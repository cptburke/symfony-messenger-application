<?php


namespace spec\CptBurke\Application\SymfonyMessenger\Command;


use CptBurke\Application\Command\Command;
use CptBurke\Application\Command\CommandBus;
use CptBurke\Application\SymfonyMessenger\Command\MessengerCommandBus;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;


class MessengerCommandBusSpec extends ObjectBehavior
{

    public function it_is_initializable(MessageBusInterface $bus): void
    {
        $this->beConstructedWith($bus);
        $this->shouldImplement(CommandBus::class);
        $this->shouldHaveType(MessengerCommandBus::class);
    }

    public function it_dispatches_command(MessageBusInterface $bus): void
    {
        $command = new class implements Command {};
        $bus->dispatch(new Envelope($command, []))
            ->willReturnArgument()
            ->shouldBeCalledOnce()
        ;

        $this->beConstructedWith($bus);
        $this->dispatch($command)
            ->shouldBeNull()
        ;
    }

    public function it_optionally_returns_result(MessageBusInterface $bus): void
    {
        $command = new class implements Command {};
        $bus->dispatch(new Envelope($command, []))
            ->willReturn(new Envelope($command, [new HandledStamp('test', 'TestHandler')]))
        ;

        $this->beConstructedWith($bus);
        $this->dispatch($command)
            ->shouldReturn('test')
        ;
    }

}

<?php


namespace CptBurke\Application\SymfonyMessenger\Event;


use CptBurke\Application\Event\ApplicationEvent;
use CptBurke\Application\Event\ApplicationEventBus;
use Symfony\Component\Messenger\MessageBusInterface;


class MessengerApplicationEventBus implements ApplicationEventBus
{

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(ApplicationEvent ...$es): void
    {
        foreach ($es as $e) {
            $this->bus->dispatch($e);
        }
    }

}

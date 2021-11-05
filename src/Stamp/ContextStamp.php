<?php


namespace CptBurke\Application\SymfonyMessenger\Stamp;


use Symfony\Component\Messenger\Stamp\StampInterface;


final class ContextStamp implements StampInterface
{

    public function __construct(
        private array $context,
    )
    {}

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

}

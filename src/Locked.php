<?php

namespace AirPetr\PhpTurnstile;

class Locked extends Turnstile
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // nothing
        // we don't want infinite loop
    }

    /**
     * @inheritDoc
     */
    public function putCoin(): void
    {
        self::$state = self::$unlockedState;
        $this->lock(false);
        $this->alarm(false);
        $this->deposit();
    }

    /**
     * @inheritDoc
     */
    public function pass(): void
    {
        $this->alarm(true);
    }
}

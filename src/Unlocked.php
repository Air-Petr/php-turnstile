<?php

namespace AirPetr\PhpTurnstile;

class Unlocked extends Turnstile
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
        $this->doRefund();
    }

    /**
     * @inheritDoc
     */
    public function pass(): void
    {
        $this->lock(true);
        self::$state = self::$lockedState;
    }
}

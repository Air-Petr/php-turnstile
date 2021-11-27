<?php

namespace AirPetr\PhpTurnstile;

class Turnstile
{
    /**
     * Alarming state.
     *
     * @var bool
     */
    private static bool $isAlarming = false;

    /**
     * Lock state.
     *
     * @var bool
     */
    private static bool $isLocked = true;

    /**
     * Amount of coins inside.
     *
     * @var int
     */
    private static int $coins = 0;

    /**
     * Amount of refunds.
     *
     * @var int
     */
    private static int $refunds = 0;

    /**
     * State.
     *
     * @var Locked|Unlocked
     */
    protected static $state;

    /**
     * Locked state.
     *
     * @var Locked
     */
    protected static Locked $lockedState;

    /**
     * Unlocked state.
     *
     * @var Unlocked
     */
    protected static Unlocked $unlockedState;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (!self::$state) {
            self::$lockedState = new Locked();
            self::$unlockedState = new Unlocked();
            self::$state = self::$lockedState;
        }
    }

    /**
     * Whether turnstile is locked.
     *
     * @return bool
     */
    public function isLocked(): bool
    {
        return self::$isLocked;
    }

    /**
     * Whether turnstile is alarming.
     *
     * @return bool
     */
    public function isAlarming(): bool
    {
        return self::$isAlarming;
    }

    /**
     * Put a coin.
     */
    public function putCoin(): void
    {
        self::$state->putCoin();
    }

    /**
     * Return amount of coins inside.
     *
     * @return int
     */
    public function coins(): int
    {
        return self::$coins;
    }

    /**
     * Make a refund.
     */
    public function doRefund(): void
    {
        self::$refunds++;
    }

    /**
     * Return amount of refunds.
     *
     * @return int
     */
    public function refunds(): int
    {
        return self::$refunds;
    }

    /**
     * Increase amount of coins.
     *
     * @return void
     */
    protected function deposit(): void
    {
        self::$coins++;
    }

    /**
     * Pass through turnstile.
     */
    public function pass(): void
    {
        self::$state->pass();
    }

    /**
     * Reset turnstile.
     */
    public function reset(): void
    {
        $this->lock(true);
        $this->alarm(false);
        self::$coins = 0;
        self::$refunds = 0;
        self::$state = self::$lockedState;
    }

    /**
     * Set lock state.
     *
     * @param bool $state
     */
    protected function lock(bool $state): void
    {
        self::$isLocked = $state;
    }

    /**
     * Set alarm state.
     *
     * @param bool $state
     */
    protected function alarm(bool $state): void
    {
        self::$isAlarming = $state;
    }
}

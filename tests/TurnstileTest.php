<?php

use AirPetr\PhpTurnstile\Turnstile;
use PHPUnit\Framework\TestCase;

class TurnstileTest extends TestCase
{
    /**
     * Setting up test.
     */
    public function setUp(): void
    {
        $turnstile = new Turnstile();
        $turnstile->reset();
    }

    /**
     * Test initialization.
     */
    public function testInit(): void
    {
        $t = new Turnstile();
        $this->assertTrue($t->isLocked());
        $this->assertFalse($t->isAlarming());
    }

    /**
     * Test coin putting.
     */
    public function testCoin(): void
    {
        $t1 = new Turnstile();
        $t1->putCoin();

        $t2 = new Turnstile();
        $this->assertFalse($t2->isLocked());
        $this->assertFalse($t2->isAlarming());
        $this->assertEquals(1, $t2->coins());
    }

    /**
     * Test one coin and passing.
     */
    public function testCoinAndPass(): void
    {
        $t1 = new Turnstile();
        $t1->putCoin();
        $t1->pass();

        $t2 = new Turnstile();
        $this->assertTrue($t2->isLocked());
        $this->assertFalse($t2->isAlarming());
        $this->assertEquals(1, $t2->coins());
    }

    /**
     * Test putting two coins.
     */
    public function testTwoCoins(): void
    {
        $t1 = new Turnstile();
        $t1->putCoin();
        $t1->putCoin();

        $t2 = new Turnstile();
        $this->assertTrue(!$t2->isLocked());
        $this->assertEquals(1, $t2->coins(), 'coins');
        $this->assertEquals(1, $t2->refunds(), 'refunds');
    }

    /**
     * Test passing without a coin.
     */
    public function testPass(): void
    {
        $t1 = new Turnstile();
        $t1->pass();

        $t2 = new Turnstile();
        $this->assertTrue($t2->isAlarming());
        $this->assertTrue($t2->isLocked());
    }

    /**
     * Test coin after pass try.
     */
    public function testCancelAlarm(): void
    {
        $t1 = new Turnstile();
        $t1->pass();
        $t1->putCoin();

        $t2 = new Turnstile();
        $this->assertTrue(!$t2->isAlarming());
        $this->assertTrue(!$t2->isLocked());
        $this->assertEquals(1, $t2->coins(), 'coins');
        $this->assertEquals(0, $t2->refunds(), 'refunds');

    }

    /**
     * Test two passings.
     */
    public function testTwoOperations(): void
    {
        $t = new Turnstile();
        $t->putCoin();
        $t->pass();
        $t->putCoin();

        $this->assertTrue(!$t->isLocked());
        $this->assertEquals(2, $t->coins(), 'coins');

        $t->pass();
        $this->assertTrue($t->isLocked());
    }
}

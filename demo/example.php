<?php

require __DIR__ . '/../vendor/autoload.php';

use AirPetr\PhpTurnstile\Turnstile;

$turnstile = new Turnstile();
$peopleToPass = 20;

for ($i = 0; $i < $peopleToPass; $i++) {
    switch (rand(0, 2)) {
        case 0:
            if ($turnstile->isLocked()) {
                $turnstile->putCoin();
            }
            break;
        case 1:
            $turnstile->pass();

            if ($turnstile->isAlarming()) {
                $turnstile->putCoin();
            }
            break;
        case 2:
            $turnstile->putCoin();
            $turnstile->putCoin();
            break;

    }

    $turnstile->pass();
}

echo "$peopleToPass people passed\n";
echo "Amount of coins: {$turnstile->coins()}\n";
echo "Amount of refunds: {$turnstile->refunds()}\n";
die();

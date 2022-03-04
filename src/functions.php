<?php

declare(strict_types=1);

namespace Nicoorfi\Insist {

    use EventSauce\BackOff\BackOffStrategy;
    use EventSauce\BackOff\ExponentialBackOffStrategy;
    use EventSauce\BackOff\FibonacciBackOffStrategy;
    use EventSauce\BackOff\ImmediatelyFailingBackOffStrategy;
    use EventSauce\BackOff\LinearBackOffStrategy;
    use EventSauce\BackOff\Jitter\Jitter;
    use EventSauce\BackOff\NoWaitingBackOffStrategy;
    use Throwable;

    function insist(callable $callback, BackOffStrategy $strategy)
    {
        $tries = 0;

        start:
        try {
            ++$tries;
            $callback();
        } catch (Throwable $throwable) {
            $strategy->backoff($tries, $throwable);
            goto start;
        }
    }

    function insist_fibonnaci(
        callable $callback,
        int $initialDelayMs,
        int $maxTries,
        int $maxDelay = 2500000,
        ?callable $sleeper = null,
        ?Jitter $jitter = null
    ) {
        insist($callback, new FibonacciBackOffStrategy($initialDelayMs, $maxTries, $maxDelay, $sleeper, $jitter));
    }

    function insist_linear(
        callable $callback,
        int $initialDelayMs,
        int $maxTries,
        int $maxDelay = 2500000,
        ?callable $sleeper = null,
        ?Jitter $jitter = null
    ) {
        insist($callback, new LinearBackOffStrategy($initialDelayMs, $maxTries, $maxDelay, $sleeper, $jitter));
    }

    function insist_exponential(
        callable $callback,
        int $initialDelayMs,
        int $maxTries,
        int $maxDelay = 2500000,
        float $base = 2.0,
        ?callable $sleeper = null,
        ?Jitter $jitter = null
    ) {
        insist($callback, new ExponentialBackOffStrategy($initialDelayMs, $maxTries, $maxDelay, $base, $sleeper, $jitter));
    }

    function insist_nowait(
        callable $callback,
        int $maxTries,
    ) {
        insist($callback, new NoWaitingBackOffStrategy($maxTries));
    }

    function insist_fail(
        callable $callback,
    ) {
        insist($callback, new ImmediatelyFailingBackOffStrategy());
    }
};

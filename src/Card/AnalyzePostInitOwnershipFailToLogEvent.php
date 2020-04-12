<?php

namespace Yosmy\Payment\Card;

use Yosmy\Payment;
use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.card.post_init_ownership_fail',
 *     ]
 * })
 */
class AnalyzePostInitOwnershipFailToLogEvent implements AnalyzePostInitOwnershipFail
{
    /**
     * @var Yosmy\LogEvent
     */
    private $logEvent;

    /**
     * @param Yosmy\LogEvent $logEvent
     */
    public function __construct(
        Yosmy\LogEvent $logEvent
    ) {
        $this->logEvent = $logEvent;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        Payment\Card $card,
        Payment\Exception $exception
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.card.init_ownership_fail',
                'fail'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId(),
            ],
            [
                'message' => $exception->getMessage()
            ]
        );
    }
}
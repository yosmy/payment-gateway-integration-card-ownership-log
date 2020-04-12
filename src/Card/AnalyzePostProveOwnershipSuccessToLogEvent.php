<?php

namespace Yosmy\Payment\Card;

use Yosmy\Payment;
use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.card.post_prove_ownership_success',
 *     ]
 * })
 */
class AnalyzePostProveOwnershipSuccessToLogEvent implements AnalyzePostProveOwnershipSuccess
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
        int $amount
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.card.prove_ownership_success',
                'success'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId(),
            ],
            [
                'amount' => $amount
            ]
        );
    }
}
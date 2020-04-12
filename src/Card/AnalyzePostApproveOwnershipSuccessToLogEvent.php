<?php

namespace Yosmy\Payment\Card;

use Yosmy\Payment;
use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.card.post_approve_ownership_success',
 *     ]
 * })
 */
class AnalyzePostApproveOwnershipSuccessToLogEvent implements AnalyzePostApproveOwnershipSuccess
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
        string $operator,
        string $reason
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.card.approve_ownership_success',
                'success'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId(),
            ],
            [
                'operator' => $operator,
                'reason' => $reason,
            ]
        );
    }
}
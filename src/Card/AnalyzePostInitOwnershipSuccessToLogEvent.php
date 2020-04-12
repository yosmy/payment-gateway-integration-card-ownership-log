<?php

namespace Yosmy\Payment\Card;

use Yosmy\Payment;
use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.card.post_init_ownership_success',
 *     ]
 * })
 */
class AnalyzePostInitOwnershipSuccessToLogEvent implements AnalyzePostInitOwnershipSuccess
{
    /**
     * @var Payment\Card\Ownership\ManageProcessCollection
     */
    private $manageProcessCollection;

    /**
     * @var Yosmy\LogEvent
     */
    private $logEvent;

    /**
     * @param Ownership\ManageProcessCollection $manageProcessCollection
     * @param Yosmy\LogEvent                    $logEvent
     */
    public function __construct(
        Ownership\ManageProcessCollection $manageProcessCollection,
        Yosmy\LogEvent $logEvent
    ) {
        $this->manageProcessCollection = $manageProcessCollection;
        $this->logEvent = $logEvent;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        Payment\Card $card
    ) {
        /** @var Ownership\Process $process */
        $process = $this->manageProcessCollection->findOne([
            '_id' => $card->getId(),
        ]);

        $this->logEvent->log(
            [
                'yosmy.payment.card.init_ownership_success',
                'success'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId(),
                'charge' => $process->getCharge(),
            ],
            [
                'amount' => $process->getAmount()->jsonSerialize(),
            ]
        );
    }
}
<?php

namespace Yosmy\Payment\Card;

use Yosmy;
use Traversable;

/**
 * @di\service()
 */
class AuditExtraPostInitOwnershipEvents
{
    /**
     * @var Yosmy\ManageEventCollection
     */
    private $manageEventCollection;

    /**
     * @param Yosmy\ManageEventCollection $manageEventCollection
     */
    public function __construct(Yosmy\ManageEventCollection $manageEventCollection)
    {
        $this->manageEventCollection = $manageEventCollection;
    }

    /**
     * @param Yosmy\Mongo\ManageCollection $manageCollection
     *
     * @return Traversable
     */
    public function audit(
        Yosmy\Mongo\ManageCollection $manageCollection
    ): Traversable
    {
        return $this->manageEventCollection->aggregate(
            [
                [
                    '$lookup' => [
                        'localField' => 'involved.user',
                        'from' => $manageCollection->getName(),
                        'as' => 'parent',
                        'foreignField' => '_id',
                    ]
                ],
                [
                    '$match' => [
                        'labels' => [
                            '$in' => [
                                'yosmy.payment.card.Init_ownership_success',
                                'yosmy.payment.card.Init_ownership_fail',
                            ]
                        ],
                        'parent._id' => [
                            '$exists' => false
                        ]
                    ],
                ]
            ]
        );
    }
}
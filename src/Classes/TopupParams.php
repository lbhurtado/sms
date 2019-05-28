<?php

namespace LBHurtado\SMS\Classes;

use LBHurtado\SMS\Contracts\Params;

class TopupParams implements Params
{
    /**
     * @var int
     */
    protected $org_id;

    /**
     * @var string
     */
    protected $mobile_number;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var string
     */
    protected $recipientType = 'mobile_number';

    /**
     * @var string
     */
    protected $reference;

    /**
     * SendParams constructor.
     * @param $org_id
     * @param $mobile_number
     * @param $amount
     * @param $reference
     */
    public function __construct(int $org_id, string $mobile_number, int $amount, string $reference)
    {
        $this->org_id = $org_id;
        $this->mobile_number = $mobile_number;
        $this->amount = $amount;
        $this->reference = $reference;
    }

    public function toArray(): array
    {
        return [
            'organizationId' => $this->org_id,
            'phoneNumber' => $this->mobile_number,
            'maxAmount' => $this->amount,
            'clientRef'  => $this->reference,
        ];
    }
}
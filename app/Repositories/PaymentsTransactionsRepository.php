<?php

namespace App\Repositories;

use App\Models\PaymentsTransactions;
use App\Repositories\BaseRepository;

class PaymentsTransactionsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'transaction_id',
        'amount',
        'paid_on',
        'details'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PaymentsTransactions::class;
    }
}

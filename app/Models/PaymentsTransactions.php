<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsTransactions extends Model
{
    public $table = 'payments_transactions';

    public $fillable = [
        'transaction_id',
        'amount',
        'paid_on',
        'details'
    ];

    protected $casts = [
        'transaction_id' => 'integer',
        'amount' => 'decimal:2',
        'paid_on' => 'date',
        'details' => 'string'
    ];

    public static array $rules = [
        'transaction_id' => 'required',
        'amount' => 'required',
        'paid_on' => 'required'
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transactions', 'transaction_id', 'id');
    }
}

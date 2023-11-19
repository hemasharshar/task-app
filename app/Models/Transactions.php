<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    public $table = 'transactions';

    // Status
    const STATUS_PAID                                   = 1;
    const STATUS_OUTSTANDING                            = 2;
    const STATUS_OVERDUE                                = 3;

    protected $appends = ['status_format'];

    public $fillable = [
        'customer',
        'amount',
        'due_date',
        'vat',
        'vat_inclusive',
        'status'
    ];

    protected $casts = [
        'customer' => 'integer',
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'vat' => 'integer',
        'vat_inclusive' => 'integer',
        'status' => 'integer'
    ];

    public static array $rules = [
        'customer' => 'required',
        'amount' => 'required',
        'due_date' => 'required',
        'vat' => 'required',
        'vat_inclusive' => 'required'
    ];


    public function getStatusFormatAttribute()
    {
        switch ($this->status) {
            case Transactions::STATUS_PAID:
                return 'Paid';
                break;
            case Transactions::STATUS_OUTSTANDING:
                return 'Outstanding';
                break;
            case Transactions::STATUS_OVERDUE:
                return 'Overdue';
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'customer', 'id');
    }
}

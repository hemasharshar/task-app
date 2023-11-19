<?php

namespace App\Repositories;

use App\Models\PaymentsTransactions;
use App\Models\Transactions;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'customer',
        'amount',
        'due_date',
        'vat',
        'vat_inclusive',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Transactions::class;
    }

    public function newTransaction($input)
    {
        $input['status'] = Carbon::now() > $input['due_date'] ? Transactions::STATUS_OVERDUE : Transactions::STATUS_OUTSTANDING;
        return $this->model()::create($input);
    }

    public function updateStatusFromPayment($payment)
    {
        $transaction = $this->model()::where('id', $payment->transaction_id)->first();
        $total_payment = PaymentsTransactions::query()->where('transaction_id', $payment->transaction_id)->sum('amount');
        $is_paid = $transaction ? ($transaction->amount == $total_payment) : false;
        if ($is_paid) {
            $transaction->update([
               'status' => Transactions::STATUS_PAID
            ]);
        }
    }

    public function getExportData()
    {
        $request_from = Carbon::parse(\request("from_date"))->format('Y-m-d');
        $request_to = Carbon::parse(\request("to_date"))->format('Y-m-d');
        return $this->model()::selectRaw('MONTH(created_at) AS month, YEAR(created_at) AS year, SUM(CASE WHEN status = 1 AND created_at >= "' . $request_from . '" AND created_at < "' . $request_to . '" THEN amount ELSE NULL END) as "paid", SUM(CASE WHEN status = 2 AND created_at >= "' . $request_from . '" AND created_at < "' . $request_to . '" THEN amount ELSE NULL END) as "outstanding", SUM(CASE WHEN status = 3 AND created_at >= "' . $request_from . '" AND created_at < "' . $request_to . '" THEN amount ELSE NULL END) as "overdue"')
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('YEAR(created_at)'))
            ->get();
    }

    public function getUserTransactions($user_id, $limit)
    {
        return $this->model()::where('customer', $user_id)->paginate($limit);
    }
}

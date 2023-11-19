<?php

namespace App\Http\Resources;

use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'customer' => $this->user->name,
          'amount' => $this->amount,
          'due_date' => Carbon::parse($this->due_date)->format('Y-m-d'),
          'vat' => $this->vat,
          'vat_inclusive' => $this->vat_inclusive,
          'status' => $this->getStatus($this->status)
        ];
    }


    private function getStatus($status)
    {
        switch ($status) {
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
}

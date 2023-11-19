<?php

namespace App\Exports;

use App\Repositories\TransactionsRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithStyles, WithHeadings, ShouldAutoSize
{

    protected $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepo)
    {
        $this->transactionsRepository = $transactionsRepo;
    }

    public function headings():array{
        return [
            'Month',
            'Year',
            'Paid',
            'Outstanding',
            'Overdue',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->transactionsRepository->getExportData();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 13]],
        ];
    }


}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $sales = Sale::all()->map(function($item) {
            $item->type = 'Sale';
            $item->date = $item->sale_date;
            $item->amount = $item->net_amount;
            $item->reference = $item->sale_number;
            return $item;
        });

        $purchases = Purchase::all()->map(function($item) {
            $item->type = 'Purchase';
            $item->date = $item->purchase_date;
            $item->amount = $item->total_amount;
            $item->reference = $item->purchase_number;
            return $item;
        });

        $expenses = Expense::all()->map(function($item) {
            $item->type = 'Expense';
            $item->date = $item->expense_date;
            $item->amount = $item->amount;
            $item->reference = $item->expense_number ?? 'EXP-' . $item->id;
            return $item;
        });

        return $sales->concat($purchases)->concat($expenses)->sortByDesc('date');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Type',
            'Reference #',
            'Amount',
            'Notes'
        ];
    }

    public function map($item): array
    {
        return [
            $item->date,
            $item->type,
            $item->reference,
            number_format($item->amount, 2),
            $item->notes ?? ''
        ];
    }
}

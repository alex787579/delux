<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Order::select(
            'dist_ch', 
            'sold_to_party_cust_code', 
            'ship_to_cust_code', 
            'material_no', 
            'qty', 
            'std_pkg', 
            'value_mrp_less_50', 
            'total_value_mrp_less_50', 
            'segment', 
            'no_of_packs', 
            'std_packing_ok_not_ok', 
            'order_value', 
            'order_id', 
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Distributor Channel',
            'Sold To Party',
            'Ship To Customer Code',
            'Material Number',
            'Quantity',
            'Standard Package',
            'Value MRP Less 50%',
            'Total Value MRP Less 50%',
            'Segment',
            'No of Packs',
            'Standard Packing Status',
            'Order Value',
            'Unique ID',
            'Status',
        ];
    }
}

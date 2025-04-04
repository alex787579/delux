<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Session;
class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $userRole = Session::get('role');
        $customerCode = Session::get('c_id');

        $query =  Order::select(
            'dist_ch', 
            'customer_code', 
            'ship_to_customer_code', 
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
        );

               // Admin: Export all records where status = 'P'
            if ($userRole === 'user') {
                $query->where('customer_code', $customerCode);
            }
    
            // ✅ Fix: Execute the query with `get()`
            return $query->get();

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

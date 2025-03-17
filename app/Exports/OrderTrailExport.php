<?php

namespace App\Exports;

use App\Models\OrderTrail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Session;
class OrderTrailExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $userRole = Session::get('role');
        $customerCode = Session::get('c_id');

        $query = OrderTrail::select(
            'customer_code', 
            'material_no', 
            'qty', 
            'std_pkg', 
            'value_mrp_less_50', 
            'total_value_mrp_less_50', 
            'segment', 
            'order_type', 
            'order_value', 
            'status'
        );

        // Admin: Export all records where status = 'P'
        if ($userRole === 'admin') {
            $query->where('status', 'P');
        } 
        // User: Export only records where customer_code matches session('c_id')
        else {
            $query->where('customer_code', $customerCode)
                  ->where('status', 'P');
        }

        // ✅ Fix: Execute the query with `get()`
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Customer Code',
            'Material Number',
            'Quantity',
            'Standard Package',
            'Value MRP Less 50%',
            'Total Value MRP Less 50%',
            'Segment',
            'Order Type',
            'Order Value',
            'Status',
        ];
    }
}

<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class OrdersListExport implements FromCollection, WithHeadings, WithMapping
{
    protected $customerCode, $fromDate, $toDate;

    public function __construct($customerCode, $fromDate, $toDate)
    {
        $this->customerCode = $customerCode;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        $query = Order::query();
    
        // Apply date filter only if fromDate and toDate are provided
        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $fromDate = Carbon::parse($this->fromDate)->startOfDay()->toDateTimeString();
            $toDate = Carbon::parse($this->toDate)->endOfDay()->toDateTimeString();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    
        // Apply customer filter only if customerCode is provided
        if (!empty($this->customerCode)) {
            $query->where('customer_code', $this->customerCode);
        }
    
        return $query->get([
            'id', 'dist_ch', 'customer_code', 'ship_to_customer_code', 'material_no', 'qty',
            'std_pkg', 'value_mrp_less_50', 'total_value_mrp_less_50', 'segment', 'no_of_packs',
            'std_packing_ok_not_ok', 'order_value', 'order_id', 'status', 'created_at', 'created_by', 'updated_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID', 'Distributor Channel', 'Customer Code', 'Ship To Customer Code', 'Material No', 
            'Quantity', 'Standard Package', 'Value MRP Less 50', 'Total Value MRP Less 50', 
            'Segment', 'No. of Packs', 'Std Packing OK/Not OK', 'Order Value', 
            'Order ID', 'Status', 'Created At', 'Created By', 'Updated At'
        ];
    }
    

    public function map($order): array
    {
        return [
            $order->id,
            $order->dist_ch,
            $order->customer_code,
            $order->ship_to_customer_code,
            $order->material_no,
            $order->qty,
            $order->std_pkg,
            $order->value_mrp_less_50,
            $order->total_value_mrp_less_50,
            $order->segment,
            $order->no_of_packs,
            $order->std_packing_ok_not_ok,
            $order->order_value,
            $order->order_id,
            $order->status,
            Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
            $order->created_by,
            Carbon::parse($order->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}

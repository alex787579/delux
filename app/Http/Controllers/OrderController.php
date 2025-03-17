<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OrderImport;
use App\Exports\OrdersExport;
use App\Exports\OrderTrailExport;
use App\Exports\OrdersListExport;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderTrail;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\OrderCreate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    //

    public function uploadForm()
    {
        $empID = session('c_id');
        $user_role = strtolower(session('role')); // Assuming role is stored in session  
    
        // If the user is Admin, fetch only records with status 'I'
        if ($user_role === 'admin') {
        $data = Order::all();
        }else{
            $data = Order::where('created_by', $empID)->get();
        }
        return view('uploadForm',['order' => $data]);
    }


public function uploads(Request $request)
{
    $file = $request->file('file');

    if (!$file) {
        return back()->with('error', 'No file uploaded.');
    }

    $order_id = 'DELUX-' . time();

    // Temporarily store the file (without moving it to public/uploads)
    $tempPath = $file->getRealPath();

    // Process Excel and validate before saving
    $import = new OrderImport($order_id);
    Excel::import($import, $tempPath);

    // Check if there are validation errors
    if (session()->has('import_errors')) {
        return back()->withErrors(session('import_errors'))->withInput();
    }

    // No errors, proceed with saving the file
    $fileName = time() . '_' . $file->getClientOriginalName();
    $destinationPath = public_path('uploads');

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $file->move($destinationPath, $fileName);

    // Save file details to database
    $orderFile = new UploadedFile();
    $orderFile->order_id = $order_id;
    $orderFile->filename = 'uploads/' . $fileName;
    $orderFile->created_at = now();
    $orderFile->updated_at = now();
    $orderFile->save();

    return back()->with('success', 'File uploaded and processed successfully!');
}

public function exportOrders($format)
    {
        $fileName = 'orders_' . date('Y-m-d_H-i-s');

        if ($format === 'xlsx') {
            return Excel::download(new OrdersExport, $fileName . '.xlsx');
        } elseif ($format === 'csv') {
            return Excel::download(new OrdersExport, $fileName . '.csv');
        } else {
            return back()->with('error', 'Invalid format selected.');
        }
    }

    public function exportOrderTrail($format)
    {
        $fileName = 'order_trail_' . date('Y-m-d_H-i-s');


        if ($format === 'xlsx') {
            return Excel::download(new OrderTrailExport, $fileName . '.xlsx');
        } elseif ($format === 'csv') {
            return Excel::download(new OrderTrailExport, $fileName . '.csv');
        } else {
            return back()->with('error', 'Invalid format selected.');
        }

        // return Excel::download(new OrderTrailExport, $fileName . '.' . $format);
    }


    public function editOrder($id)
    {
        $orderId = Crypt::decryptString($id);

        // echo $orderId ;
        // exit;
        $order = OrderTrail::find($orderId);
    
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }
    
        return view('order_edit_trail', compact('order'));
    }


    public function approvedOrder($id)
    {
        $order_id = Crypt::decryptString($id); // Decrypt order_id
    
        // Update order status if it's currently "P"
        $order = Order::where('order_id', $order_id)->where('status', 'P')->first();
    
        if ($order) {
            $order->status = 'A'; // Approved
            $order->save();
            return back()->with('success', 'Order approved successfully!');
        }
    
        return back()->with('error', 'Order not found or already approved.');
    }


    // Order Create STart

    
    public function createOrder()
    {
        return view('order_create');
    }


    // Order Create End


    public function getMaterials(Request $request)
    {
        $search = $request->query('search'); // Get search query

        $materials = Material::where('material_no', 'LIKE', "%{$search}%")
            ->orWhere('part_number', 'LIKE', "%{$search}%")
            ->limit(10) // Limit results to 10 for performance
            ->get(['id', 'material_no', 'part_number', 'std_pkg','value_mrp_less_50','segment','dist_ch']);

        return response()->json($materials);
    }
    

    public function OrderTrail()
    {
        $customer_code = session('c_id');
        $user_role = strtolower(session('role')); // Assuming role is stored in session  
    
        // If the user is Admin, fetch only records with status 'I'
        if ($user_role === 'admin') {
            $model = OrderTrail::where('status', 'I')->get();
        } 
        // If the user is not Admin, fetch records where customer_code matches and status is 'P' or 'I'
        else {
            if (!$customer_code) {
                return response()->json(['error' => 'Customer code not found in session'], 400);
            }
            $model = OrderTrail::where('customer_code', $customer_code)
                                ->whereIn('status', ['P', 'I'])
                                ->get();
        }
    
        return view('order_trail', ['order' => $model]);
    }
    

    public function storeTrailOrders(Request $request)
    {

    try {
        $orderIds = $request->order_ids;

        if (!is_array($orderIds) || empty($orderIds)) {
            return response()->json(['error' => true, 'message' => 'No orders selected.'], 400);
        }

        // Get the user's role from the session
        $userRole = strtolower(session('role'));

        // Fetch orders based on role and status condition
        $trails = OrderTrail::whereIn('id', $orderIds)->get();

        if ($trails->isEmpty()) {
            return response()->json(['error' => true, 'message' => 'No valid orders found.'], 404);
        }

        foreach ($trails as $trail) {
            // If the order status is 'P' and the user is 'user', just update the status
            if ($trail->status == 'P' && $userRole == 'user') {
                $trail->update(['status' => 'I']); // Change status without creating an order
            }
            // If the order status is 'I' and the user is 'admin', create a new order
            elseif ($trail->status == 'I' && $userRole == 'admin') {

             Order::create([
                    'std_pkg' => $trail->std_pkg,
                    'qty' => $trail->qty,
                    'material_no' => $trail->material_no,
                    'segment' => $trail->segment,
                    'customer_code' => $trail->customer_code,
                    'order_id' => $trail->order_id,
                    'total_value_mrp_less_50' => $trail->total_value_mrp_less_50,
                    'value_mrp_less_50' => $trail->value_mrp_less_50,
                    'order_value' => $trail->order_value,
                    'created_by' => $trail->created_by,
                    'no_of_packs' => $trail->no_of_packs,
                    'dist_ch' => $trail->dist_ch,
                    'ship_to_customer_code' => $trail->ship_to_customer_code,
                    'status' => 'A',
                    // Add other necessary fields here
                ]);
                
                // Update the status in OrderTrail
                $trail->update(['status' => 'A']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Orders processed successfully.']);

    } catch (\Exception $e) {
        return response()->json(['error' => true, 'message' => 'Error: ' . $e->getMessage()]);
    }
}


    public function deleteOrder($id)
    {
        $order = OrderTrail::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found!'], 404);
        }

        $order->delete();
        return response()->json(['success' => 'Order deleted successfully!']);
    }
    


    public function store(Request $request)
    {
    try {
        // Validate input fields
        $validated = $request->validate([
            'material_no' => 'required',
            'order_type' => 'required',
            'qty' => 'required|integer|min:1',
        ], [
            'material_no.required' => 'Material No is required.',
            'order_type.required' => 'Order Type is required.',
            'qty.required' => 'Quantity is required.',
            'qty.integer' => 'Quantity must be a valid number.',
            'qty.min' => 'Quantity must be at least 1.',
        ]);

        $customer_code = session('c_id');
        $order_id = 'DELUX-' . time();

        $order = new OrderTrail;
        $order->customer_code = $customer_code;
        $order->std_pkg = $request->std_pkg;
        $order->value_mrp_less_50 = $request->value_mrp_less_50;
        $order->segment = $request->segment;
        $order->qty = $request->qty;
        $order->total_value_mrp_less_50 = $order->value_mrp_less_50 * $order->qty;
        $order->material_no = $request->material_no;
        $order->order_type = $request->order_type;
        $order->order_value = $order->value_mrp_less_50 * $order->qty;
        $order->created_by = $customer_code;
        $order->order_id = $order_id;
        $order->status = 'P';
        $order->ship_to_customer_code = $request->ship_to_customer_code;
        $order->no_of_packs = $request->no_of_packs;
        $order->dist_ch = $request->dist_ch;

        if ($order->save()) {
            return response()->json(['success' => true, 'message' => 'Order saved successfully!']);
        } else {
            return response()->json(['error' => true, 'message' => 'Unable to save order!']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}


public function update(Request $request, $id)
{
    // Validate input fields
    $request->validate([
        'std_pkg' => 'required',
        'value_mrp_less_50' => 'required|numeric|min:0',
        'segment' => 'required',
        'qty' => 'required|numeric|min:1',
        'material_no' => 'required',
        'order_type' => 'required|in:Regular,Advance', // Ensure order_type is valid
    ]);

    // Find order by ID
    $order = OrderTrail::find($id);

    if (!$order) {
        return response()->json(['error' => true, 'message' => 'Order not found!']);
    }

    try {
        // Update order details
        $order->std_pkg = $request->std_pkg;
        $order->value_mrp_less_50 = $request->value_mrp_less_50;
        $order->segment = $request->segment;
        $order->qty = $request->qty;
        $order->material_no = $request->material_no;
        $order->order_type = $request->order_type;
        $order->order_value = $request->value_mrp_less_50 * $request->qty;
        $order->total_value_mrp_less_50 = $request->value_mrp_less_50 * $request->qty;

        if ($order->save()) {
            return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
        }
        
        return response()->json(['error' => true, 'message' => 'Failed to update order!']);

    } catch (\Exception $e) {
        return response()->json(['error' => true, 'message' => 'Error: ' . $e->getMessage()]);
    }
}


public function exportOrdersList(Request $request)
    {

        // return $request->post();
        // exit;
        // $request->validate([
        //     'customer_code' => 'required|string',
        //     'from_date' => 'required|date',
        //     'to_date' => 'required|date|after_or_equal:from_date',
        // ]);

        $customerCode = $request->customer_code;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        // File name with timestamp
        $fileName = 'orders_export_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new OrdersListExport($customerCode, $fromDate, $toDate), $fileName);
    }


}
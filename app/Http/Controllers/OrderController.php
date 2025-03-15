<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OrderImport;
use App\Exports\OrdersExport;
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
        $empID = session('EMPID');
        $data = Order::where('created_by', $empID)->get();
        return view('uploadForm',['order' => $data]);
    }

    public function OrderFiles()
    {
        $empID = session('EMPID');
        $data = UploadedFile::whereHas('order', function ($query) use ($empID) {
            $query->where('created_by', $empID); // Ensure order is created by logged-in user
        })->with('order')->get();
    
        return view('order_files', ['data' => $data]);
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
            ->get(['id', 'material_no', 'part_number', 'std_pkg','value_mrp_less_50','segment']);

        return response()->json($materials);
    }
    

    public function OrderTrail()
    {
        $model = OrderTrail::all();

        return view('order_trail',['order' => $model]);
    }

    public function storeTrailOrders(Request $request)
    {
        try {
            $orderIds = $request->order_ids;
    
            if (!is_array($orderIds) || empty($orderIds)) {
                return response()->json(['error' => true, 'message' => 'No orders selected.'], 400);
            }
    
            $trails = OrderTrail::whereIn('id', $orderIds)->where('status', 'Pending')->get();
    
            if ($trails->isEmpty()) {
                return response()->json(['error' => true, 'message' => 'No valid orders found.'], 404);
            }
    
            foreach ($trails as $trail) {
                Order::create([
                    'std_pkg' => $trail->std_pkg,
                    'qty' => $trail->qty,
                    'material_no' => $trail->material_no,
                    'segment' => $trail->segment,
                    'value_mrp_less_50' => $trail->total_value_mrp_less_50,
                    // Add other necessary fields here
                ]);
    
                // Delete the trail record from OrderTrail
                $trail->delete();
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
            $order = new OrderTrail;
            $order->ship_to_cust_code = $request->customerCode;
            $order->std_pkg = $request->std_pkg;
            $order->value_mrp_less_50 = $request->value_mrp_less_50;
            $order->segment = $request->segment;
            $order->qty = $request->qty;  
            $order->total_value_mrp_less_50 = $order->value_mrp_less_50 * $order->qty;
            $order->material_no = $request->material_no;
            $order->order_type = $request->order_type;
            $order->status = 'Pending';
    
            if ($order->save()) {
                $email = session('email');
                Mail::to($email)->send(new OrderCreate($order));
    
                return response()->json(['success' => true, 'message' => 'Order saved successfully! Email sent.']);
            } else {
                return response()->json(['error' => true, 'message' => 'Unable to save order!']);
            }
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

// Update OrderTrail Model in Controller
// public function updateOrderTrail(Request $request, $id)
// {
//     $order = OrderTrail::find($id);
    
//     if (!$order) {
//         return response()->json(['error' => true, 'message' => 'Order not found!']);
//     }
    
//     $order->std_pkg = $request->std_pkg;
//     $order->value_mrp_less_50 = $request->value_mrp_less_50;
//     $order->segment = $request->segment;
//     $order->qty = $request->qty;
//     $order->material_no = $request->material_no;
//     $order->order_type = $request->order_type;
//     $order->status = $request->status ?? $order->status; 
    
//     if ($order->save()) {
//         return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
//     }
//     return response()->json(['success' => false, 'message' => 'Failed to update order!']);
// }


// Update OrderTrail Model
public function update(Request $request, $id)
{


    // return $request->post();
    $order = OrderTrail::find($id);
    
    if (!$order) {
        return response()->json(['error' => true, 'message' => 'Order not found!']);
    }
    
    $order->std_pkg = $request->std_pkg;
    $order->value_mrp_less_50 = $request->value_mrp_less_50;
    $order->segment = $request->segment;
    $order->qty = $request->qty;
    $order->material_no = $request->material_no;
    $order->order_type = $request->order_type;
    $order->status = 'P';
    
    if ($order->save()) {
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
    
    return response()->json(['error' => true, 'message' => 'Failed to update order!']);
}


}
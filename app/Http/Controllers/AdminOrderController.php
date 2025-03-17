<?php

namespace App\Http\Controllers;

use App\Models\OrderTrail;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_create_admin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $order_id = 'DELUX-' . time();

        $order = new OrderTrail();
        $order->customer_code = $request->customer_code;
        $order->std_pkg = $request->std_pkg;
        $order->value_mrp_less_50 = $request->value_mrp_less_50;
        $order->segment = $request->segment;
        $order->qty = $request->qty;
        $order->total_value_mrp_less_50 = $order->value_mrp_less_50 * $order->qty;
        $order->material_no = $request->material_no;
        $order->order_type = $request->order_type;
        $order->order_value = $order->value_mrp_less_50 * $order->qty;
        $order->created_by =$request->customer_code;
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

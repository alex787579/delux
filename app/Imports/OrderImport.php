<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class OrderImport implements ToCollection
{
    protected $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    public function collection(Collection $rows)
{
    $errors = [];
    $validRows = [];

    foreach ($rows as $index => $row) {
        // Skip header row
        if ($index == 0) continue;

        // Extract values
        $dist_ch = $row[0];
        $sold_to_party = $row[1];
        $ship_to_cust_code = $row[2];
        $material_no = $row[3];
        $qty = (int) $row[4];
        $std_pkg = (int) $row[5];
        $value_mrp_less_50 = (float) $row[6];
        $total_value_mrp_less_50 = (float) $row[7];
        $segment = $row[8] ?? null;

        // Validation
        if (!$dist_ch || !$sold_to_party || !$ship_to_cust_code || !$material_no || !$std_pkg || !$value_mrp_less_50) {
            $errors[] = "Row " . ($index + 1) . ": Required fields are missing.";
            continue;
        }

        if ($qty <= 0) {
            continue; // Skip row
        }

        // Validate expected total value
        $expected_total_value = $qty * $value_mrp_less_50;
        // if ($total_value_mrp_less_50 != $expected_total_value) {
        //     $errors[] = "Row " . ($index + 1) . ": Incorrect Total Value @ MRP Less 50%, expected {$expected_total_value}.";
        //     continue;
        // }

        // Calculate No of Packs
        $expected_no_of_packs = $qty / $std_pkg;


        // Check if standard packing is OK
        $std_packing_ok_not_ok = ($qty % $std_pkg == 0) ? "Std Packing Ok" : "Standard Packing Not OK";

        if ($std_packing_ok_not_ok == "Standard Packing Not OK") {
            $errors[] = "Row " . ($index + 1) . ": Standard Packing Not OK. Quantity must be a multiple of STD pkg.";
            continue;
        }

        // If all validations pass, add row to validRows array
        $validRows[] = [
            'dist_ch' => $dist_ch,
            'sold_to_party_cust_code' => $sold_to_party,
            'ship_to_cust_code' => $ship_to_cust_code,
            'material_no' => $material_no,
            'qty' => $qty,
            'std_pkg' => $std_pkg,
            'value_mrp_less_50' => $value_mrp_less_50,
            'total_value_mrp_less_50' => $expected_total_value,
            'segment' => $segment,
            'no_of_packs' => $expected_no_of_packs,
            'std_packing_ok_not_ok' => $std_packing_ok_not_ok,
            'order_value' => $expected_total_value,
            'order_id' => $this->order_id,
            'status' => 'P', // Default status
            'created_by' => session('EMPID'), // Default status
        ];
    }

    // If there are errors, prevent saving to the database
    if (!empty($errors)) {
        session()->flash('import_errors', $errors);
        return;
    }

    // Insert valid data into DB only if no errors
    foreach ($validRows as $row) {
        Order::create($row);
    }
}


    public function collectio32n(Collection $rows)
    {
  
        $errors = [];
        foreach ($rows as $index => $row) {
            // Skip header row
            if ($index == 0) continue;

            // Extract values
            $dist_ch = $row[0];
            $sold_to_party = $row[1];
            $ship_to_cust_code = $row[2];
            $material_no = $row[3];
            $qty = (int) $row[4]; // Convert to integer
            $std_pkg = (int) $row[5];
            $value_mrp_less_50 = (float) $row[6];
            $total_value_mrp_less_50 = (float) $row[7];
            $segment = $row[8] ?? null;

            // Validation
            if (!$dist_ch || !$sold_to_party || !$ship_to_cust_code || !$material_no || !$std_pkg || !$value_mrp_less_50) {
                $errors[] = "Row " . ($index + 1) . ": Required fields are missing.";
                continue;
            }

            if ($qty <= 0) {
                continue; // Skip row
            }

            // if ($qty < $std_pkg) {
            //     $errors[] = "Row " . ($index + 1) . ": Quantity should be at least STD pkg value ({$std_pkg}).";
            //     continue;
            // }

            // // Validate total value
            // $expected_total_value = $qty * $value_mrp_less_50;
            // if ($total_value_mrp_less_50 != $expected_total_value) {
            //     $errors[] = "Row " . ($index + 1) . ": Incorrect Total Value @ MRP Less 50%, expected {$expected_total_value}.";
            //     continue;
            // }

            // Calculate No of Packs
            $expected_no_of_packs = $qty / $std_pkg;

            // // Check if standard packing is OK
            $std_packing_ok_not_ok = ($qty % $std_pkg == 0) ? "Std Packing Ok" : "Standard Packing Not OK";

            // if ($std_packing_ok_not_ok == "Standard Packing Not OK") {
            //     $errors[] = "Row " . ($index + 1) . ": Standard Packing Not OK. Quantity must be a multiple of STD pkg.";
            //     continue;
            // }

            // print_r($dist_ch);
            // exit;

            // Insert into DB
            Order::create([
                'dist_ch' => $dist_ch,
                'sold_to_party_cust_code' => $sold_to_party,
                'ship_to_cust_code' => $ship_to_cust_code,
                'material_no' => $material_no,
                'qty' => $qty,
                'std_pkg' => $std_pkg,
                'value_mrp_less_50' => $value_mrp_less_50,
                'total_value_mrp_less_50' => $total_value_mrp_less_50,
                'segment' => $segment,
                'no_of_packs' => $expected_no_of_packs,
                'std_packing_ok_not_ok' => $std_packing_ok_not_ok,
                'order_value' => $total_value_mrp_less_50,
                // 'unique_id' => rand(),
            ]);
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors)); // Throw errors to be caught in the controller
        }

        // if (!empty($errors)) {
        //     session()->flash('import_errors', $errors);
        // }
    }

    public function collection111(Collection $rows) 
{
    Log::info("OrderImport: Processing started");

    $errors = [];
    foreach ($rows as $index => $row) {
        if ($index == 0) continue; // Skip header row

        $dist_ch = $row[0];
        $sold_to_party = $row[1];
        $ship_to_cust_code = $row[2];
        $material_no = $row[3];
        $qty = (int) $row[4];
        $std_pkg = (int) $row[5];
        $value_mrp_less_50 = (float) $row[6];
        $total_value_mrp_less_50 = (float) $row[7];
        $segment = $row[8] ?? null;

        Log::info("Processing Row $index: Material No - $material_no, QTY - $qty");

        if (!$dist_ch || !$sold_to_party || !$ship_to_cust_code || !$material_no || !$std_pkg || !$value_mrp_less_50) {
            $errors[] = "Row " . ($index + 1) . ": Required fields are missing.";
            Log::error("Row $index: Missing required fields.");
            continue;
        }

        if ($qty <= 0) {
            Log::warning("Row $index: Quantity is zero or less, skipping.");
            continue;
        }

        if ($qty < $std_pkg) {
            $errors[] = "Row " . ($index + 1) . ": Quantity should be at least STD pkg value ({$std_pkg}).";
            Log::error("Row $index: Quantity is less than STD package.");
            continue;
        }

        $expected_total_value = $qty * $value_mrp_less_50;
        if ($total_value_mrp_less_50 != $expected_total_value) {
            $errors[] = "Row " . ($index + 1) . ": Incorrect Total Value @ MRP Less 50%, expected {$expected_total_value}.";
            Log::error("Row $index: Incorrect total value.");
            continue;
        }

        $expected_no_of_packs = $qty / $std_pkg;
        $std_packing_ok_not_ok = ($qty % $std_pkg == 0) ? "Std Packing Ok" : "Standard Packing Not OK";

        if ($std_packing_ok_not_ok == "Standard Packing Not OK") {
            $errors[] = "Row " . ($index + 1) . ": Standard Packing Not OK. Quantity must be a multiple of STD pkg.";
            Log::error("Row $index: Standard Packing Not OK.");
            continue;
        }

        // Save Order
        $order = Order::create([
            'dist_ch' => $dist_ch,
            'sold_to_party_cust_code' => $sold_to_party,
            'ship_to_cust_code' => $ship_to_cust_code,
            'material_no' => $material_no,
            'qty' => $qty,
            'std_pkg' => $std_pkg,
            'value_mrp_less_50' => $value_mrp_less_50,
            'total_value_mrp_less_50' => $total_value_mrp_less_50,
            'segment' => $segment,
            'no_of_packs' => $expected_no_of_packs,
            'std_packing_ok_not_ok' => $std_packing_ok_not_ok,
            'order_value' => $total_value_mrp_less_50,
            'unique_id' => Str::uuid(),
        ]);

        Log::info("Row $index: Order stored successfully with ID {$order->id}");
    }

    if (!empty($errors)) {
        session()->flash('import_errors', $errors);
    }

}
    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $index => $row) {
    //         if ($index == 0) continue; // Skip header row
            
    //         // Extract values from Excel
    //         $qty = intval($row[4]);
    //         $std_pkg = intval($row[5]);
    //         $value_mrp_less_50 = floatval($row[6]);

    //         // Validate QTY - Only insert rows with QTY
    //         if ($qty <= 0) {
    //             continue;
    //         }

    //         // Validate STD Package
    //         if ($qty < $std_pkg) {
    //             session()->flash('error', "Error in row {$index}: Minimum order should be at least {$std_pkg}");
    //             continue;
    //         }

    //         Order::create([
    //             'dist_ch' => $row[0],
    //             'sold_to_party_cust_code' => $row[1],
    //             'ship_to_cust_code' => $row[2],
    //             'material_no' => $row[3],
    //             'qty' => $qty,
    //             'std_pkg' => $std_pkg,
    //             'value_mrp_less_50' => $value_mrp_less_50,
    //             'total_value_mrp_less_50' => floatval($row[7]),
    //             'segment' => $row[8],
    //             'no_of_packs' => floatval($row[9]),
    //             'std_packing_ok_not_ok' => $row[10],
    //             'order_value' => floatval($row[11]),
    //             'unique_id' => Str::random(10),
    //         ]);
    //     }
    // }



}

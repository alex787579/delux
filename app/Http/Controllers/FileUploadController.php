<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\Order;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\UploadedFile;
class FileUploadController extends Controller
{
    
public function download($order_id)
{
    // Find the file using order_id
    $model = UploadedFile::where('order_id', trim($order_id))->first();

    // Check if file exists in the database
    if (!$model) {
        return back()->with('error', 'No file found for this order.');
    }

    $filename = $model->filename; // Get the filename

    // Ensure file exists in storage
    $filePath = public_path($filename); // Ensure path is correct

    if (File::exists($filePath)) {
        return response()->download($filePath);
    } else {
        return back()->with('error', 'File does not exist.');
    }
}

    
    public function uploadOrderFile(Request $request)
    {
        echo "<pre>";
        print_r($_FILES);
        exit;
        
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,csv|max:2048',
        // ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $destinationPath = public_path('uploads'); // Save in public/uploads
    
            // Ensure directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
    
            // Move file to public/uploads
            $file->move($destinationPath, $fileName);
    
            // Insert record into `template_order_files` table
            $orderFile = new Order();
            $orderFile->order_id = rand(); // Set dynamic order_id as needed
            $orderFile->filename = 'uploads/' . $fileName;
            $orderFile->created_at = now();
            $orderFile->updated_at = now();
            $orderFile->save();
    
            return back()->with('success', 'File uploaded successfully! Path: ' . url('uploads/' . $fileName));
        }
    
        return back()->with('error', 'File not uploaded');
    }
    



    public function uploadFile(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,csv|max:2048'
        // ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));
            return back()->with('success', 'File uploaded and data imported successfully.');
        } catch (\Exception $e) {

            echo $e->getMessage();
            exit;
            // return back()->with('error', 'Error processing the file: ' . $e->getMessage());
        }
    }
}

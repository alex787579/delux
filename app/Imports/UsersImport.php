<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // dd($row);
        // exit;
      // Debugging: dump the row to see its structure
      \Log::info($row);

      return new User([
          'name'  => $row['name'] ?? null,  // Handle missing keys
          'email' => $row['email'] ?? null, // Handle missing keys
      ]);


       // Check if the 'order' column exists and is greater than 2
       if (isset($row['order']) && $row['order'] > 2) {
        return new User([
            'name'  => $row['name'] ?? null,
            'email' => $row['email'] ?? null,
            'order' => $row['order'] ?? null, // Add 'order' column
        ]);
    }

    
    }
}

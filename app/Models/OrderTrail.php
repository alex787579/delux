<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrail extends Model
{
    use HasFactory;

    protected $table = 'orders_trail';

    protected $fillable = [
        'status','customer_code'
    ];

    // protected $fillable = [
    //     'dist_ch', 'sold_to_party_cust_code', 'ship_to_cust_code', 'material_no', 
    //     'qty', 'std_pkg', 'value_mrp_less_50', 'total_value_mrp_less_50', 'segment', 
    //     'no_of_packs', 'std_packing_ok_not_ok', 'order_value', 'order_id','status','created_by'
    // ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    // protected $guarded = [];

    protected $fillable = [
        'std_pkg', 'qty', 'material_no', 'segment', 'customer_code', 'order_id',
        'total_value_mrp_less_50', 'value_mrp_less_50', 'order_value', 'created_by', 
        'no_of_packs', 'customer_id','dist_ch','ship_to_customer_code','status'
    ];

    // protected $fillable = [
    //     'std_pkg',
    //     'qty',
    //     'material_no',
    //     'order_type',
    //     'segment',
    //     'value_mrp_less_50',
    //     'status'
    // ];

    // protected $fillable = [
    //     // 'dist_ch', 'sold_to_party_cust_code', 'ship_to_cust_code', 'material_no', 
    //     // 'qty', 'std_pkg', 'value_mrp_less_50', 'total_value_mrp_less_50', 'segment', 
    //     // 'no_of_packs', 'std_packing_ok_not_ok', 'order_value', 'order_id','status','created_by'
    // ];

    // public function uploadedFiles()
    // {
    //     return $this->hasMany(UploadedFile::class, 'order_id', 'order_id');
    // }
}

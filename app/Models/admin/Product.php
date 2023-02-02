<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

     protected $fillable = [
        'name', 'sku','description', 'unit', 'unit_price' ,'direct_cost', 'tax_rate', 'tax_label','is_active','created_by'];
    
}

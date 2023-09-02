<?php

namespace App\Models;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description' ,
         'price' ,
        'brands_id',
        'image' ,
    ];


    protected function image():Attribute {
        return Attribute::make(
            get:fn($value)=>asset('images/products/'.$value)
        );
    }
    /**
     * Get the brands that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}

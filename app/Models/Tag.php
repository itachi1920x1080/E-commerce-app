<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // ត្រូវតែមានសម្រាប់ UUID

class Tag extends Model
{
    use HasFactory, HasUuids;

    // នៅក្នុង SQL របស់អ្នក តារាង tags មានតែ inserted_at គ្មាន updated_at ទេ
    const CREATED_AT = 'inserted_at';
    const UPDATED_AT = null; 

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * ទំនាក់ទំនង Many-to-Many ជាមួយ Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags', 'tag_id', 'product_id');
    }
}
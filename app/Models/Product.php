<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasFactory, HasUuids;

    const CREATED_AT = 'inserted_at';
    const UPDATED_AT = 'updated_at'; 

    protected $fillable = [
        'sku',
        'name',
        'regular_price',
        'qty',
        'slug', 
        'image',
        'discount_price',
        'currency',
        'product_status_id',
        'description',
        'is_free',
        'taxable',
    ];

    /**
     * 🔗 Relationship ទៅកាន់ Categories (Many-to-Many)
     */
   /**
     * 🔗 Relationship ទៅកាន់ Categories (Many-to-Many)
     */
    public function categories()
    {
        // 🎯 FIXED: ប្តូរមកប្រើឈ្មោះតារាងពិតប្រាកដក្នុង DB របស់បងគឺ 'product_categories'
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * 🔗 Relationship ទៅកាន់ Tags (Many-to-Many)
     */
    public function tags()
    {
        // 🎯 FIXED: ប្តូរមកប្រើឈ្មោះតារាងពិតប្រាកដក្នុង DB របស់បងគឺ 'product_tags'
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
}
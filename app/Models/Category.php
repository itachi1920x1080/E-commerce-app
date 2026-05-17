<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // ត្រូវតែមានសម្រាប់ UUID

class Category extends Model
{
    use HasFactory, HasUuids;

    // ⏱️ Config ពេលវេលា៖ ប្រើ inserted_at និងបិទចោល updated_at ដែលគ្មានក្នុងតារាង
    const CREATED_AT = 'inserted_at';
    const UPDATED_AT = null; // 🎯 FIX រួចរាល់៖ ប្រាប់ Laravel មិនបាច់រក ឬធ្វើបច្ចុប្បន្នភាព updated_at ឡើយ

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];

    /**
     * ទំនាក់ទំនងទៅកាន់ Category មេ (Parent)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * ទំនាក់ទំនងទៅកាន់ Sub-categories កូនៗ
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * ទំនាក់ទំនង Many-to-Many ជាមួយ Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
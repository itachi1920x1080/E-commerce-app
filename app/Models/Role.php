<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $incrementing = false; // ប្រាប់ថា ID មិនមែនជាលេខរៀង
    protected $keyType = 'string'; // ប្រាប់ថា ID ជាប្រភេទអក្សរ (UUID)

    protected $fillable = ['id', 'name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
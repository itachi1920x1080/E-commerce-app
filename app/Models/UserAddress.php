<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    // 🎯 ទុកតែមួយបន្ទាត់នេះ គឺគ្រប់គ្រាន់សម្រាប់បិទការទាមទារ created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'full_name', // 🎯 ត្រូវតែបន្ថែមបន្ទាត់នេះចូល
        'address',
        'city',
        'state',
        'zip_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
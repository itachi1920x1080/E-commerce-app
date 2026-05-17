<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // ត្រូវតែមានសម្រាប់ប្រព័ន្ធ UUID

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    // ប្រាប់ Laravel ឱ្យស្គាល់ឈ្មោះ Column ថ្ងៃខែឆ្នាំដែលអ្នកបានបង្កើតក្នុង SQL
    const CREATED_AT = 'inserted_at';
    const UPDATED_AT = 'updated_at';

    /**
     * កំណត់ Column ណាខ្លះដែលអនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យ (Mass Assignable)
     * ត្រូវរៀបចំឱ្យត្រូវតាម Schema ថ្មីទាំងស្រុង (លុប role_id ចេញ និងប្តូរទៅជា password_hash)
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password_hash', // ប្តូរពី password មក password_hash វិញ
        'address',
        'city',
        'state',
        'zip_code',
        'active',
    ];

    /**
     * លាក់ព័ត៌មានសម្ងាត់នៅពេលទាញទិន្នន័យមកបង្ហាញ
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * កំណត់ប្រភេទព័ត៌មាន (Casting)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_hash' => 'hashed',
        'active' => 'boolean',
    ];

    /**
     * ⚠️ ចំណុចសំខាន់៖ ដោយសារក្នុង DB អ្នកប្រើឈ្មោះ 'password_hash' 
     * តែប្រព័ន្ធលំនាំដើមរបស់ Laravel រំពឹងរកពាក្យ 'password' 
     * ដូច្នេះយើងត្រូវបន្ថែម function នេះដើម្បីប្រាប់ Laravel ឱ្យទៅផ្ទៀងផ្ទាត់ចំ Column 'password_hash' វិញ
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * ប្តូរទំនាក់ទំនងទៅជា Many-to-Many តាមរយៈតារាងកណ្តាល user_roles វិញ
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                    ->withPivot('inserted_at');
    }

    /**
     * មុខងារជំនួយសម្រាប់ឆែកមើលសិទ្ធិ (ឧទាហរណ៍៖ $user->hasRole('admin'))
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
    /**
     * 🔗 ទំនាក់ទំនងទៅកាន់តារាងអាសយដ្ឋាន (User Has One Address)
     */
    /**
     * 🔗 ទំនាក់ទំនងទៅកាន់តារាងអាសយដ្ឋាន
     */
    public function addresses()
    {
        // 🎯 FIXED: សរសេរតែប៉ុណ្ណេះគឺគ្រប់គ្រាន់ និងត្រឹមត្រូវបំផុតបង
        return $this->hasOne(UserAddress::class);
    }
}
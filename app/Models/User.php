<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\kpi_records; // Assuming this is the correct namespace for kpi_recordsiRecord
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'users';
    protected $guarded = []; 

    protected $fillable = [
        'nip', 
        'name', 
        'email', 
        'password', 
        'jabatan', 
        'departemen', 
        'role', 
        'join_date',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
    
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    // public function kpiRecords()
    // {
    //     return $this->hasMany(kpi_records::class, 'user_id');
    // }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

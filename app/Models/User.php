<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\kpi_records;
use Spatie\Permission\Traits\HasRoles;
use App\Models\JobPosition;

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
        'job_position_id',
        'departemen',
        'role',
        'join_date',
        'photo'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function kpiMetrics()
    {
        return $this->hasMany(KpiMetrics::class);
    }

    public function kpiRecords()
    {
        return $this->hasMany(\App\Models\KpiRecord::class, 'user_id');
    }

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

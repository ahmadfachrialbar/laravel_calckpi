<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiMetrics extends Model
{
    use HasFactory;

    protected $table = 'KpiMetrics';
    protected $guarded = [];

    protected $fillable = [
        'nama_kpi',
        'penjelasan_sederhana',
        'cara_ukur',
        'target',
        'bobot',
        'user_id',             
        'job_position_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}

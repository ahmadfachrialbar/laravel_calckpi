<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kpiMetrics()
    {
        return $this->hasMany(KpiMetrics::class,  'job_position_id');
    }
}

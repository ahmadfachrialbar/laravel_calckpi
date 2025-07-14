<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiRecord extends Model
{
    use HasFactory;

    protected $table = 'kpi_records';
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'kpimetrics_id',
        'simulasi_penambahan',
        'achievement',
        'weightages',
        'score',
    ];


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kpiMetric()
    {
        return $this->belongsTo(KpiMetrics::class, 'kpimetrics_id');
    }
}

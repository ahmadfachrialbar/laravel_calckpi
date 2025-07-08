<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiMetrics extends Model
{

    use HasFactory;

    protected $table = 'KpiMetrics'; 
    protected $guarded = []; 
    
    // protected $primaryKey = 'metric_id'; 
    protected $fillable = [
        'nama_kpi',
        'penjelasan_sederhana',
        'cara_ukur',
        'target',
        'bobot',
    ];
    

    // public function kpiRecords()
    // {
    //     return $this->hasMany(kpi_records::class, 'metric_id');
    // }
}

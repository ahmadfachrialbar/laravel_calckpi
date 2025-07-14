<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class faq extends Model
{
    protected $fillable = ['judul', 'isi', 'pdf_path'];
}

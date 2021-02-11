<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiDetail extends Model
{
    use HasFactory;

    protected $table = "referensi_detail";

    protected $guarded = [];

    public function referensi()
    {
        return $this->belongsTo('App\Models\Referensi');
    }
}

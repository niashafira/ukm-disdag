<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervensiDetail extends Model
{
    use HasFactory;
    protected $table = "intervensi_detail";

    protected $guarded = [];

    public function intervensi()
    {
        return $this->belongsTo('App\Models\Intervensi');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervensiDetail extends Model
{
    use HasFactory;
    protected $table = "detail_intervensi";

    protected $guarded = [];

    public function intervensi()
    {
        return $this->belongsTo('App\Models\Intervensi');
    }
}

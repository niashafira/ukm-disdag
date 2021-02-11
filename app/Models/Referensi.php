<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    use HasFactory;
    protected $table = "referensi";
    protected  $primaryKey = 'kode';
    public $keyType = 'string';

    protected $guarded = [];

    public function referensiDetail()
    {
        return $this->hasMany('App\Models\ReferensiDetail');
    }
}

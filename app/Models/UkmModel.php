<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkmModel extends Model
{
    use HasFactory;
    protected $table = "data_ukm";

    protected $guarded = [];
}

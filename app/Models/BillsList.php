<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsList extends Model
{
    use HasFactory;
    protected $fillable = ["bill_id","name","amount","price"];
}

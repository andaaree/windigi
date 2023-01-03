<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    public function plans()
    {
        return $this->belongsTo(Plan::class,'p_key_id','p_key_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Plan extends Model
{
    use HasFactory;
    
    public function keys()
    {
        return $this->hasOne(Key::class,'p_key_id','p_key_id');
    }
}

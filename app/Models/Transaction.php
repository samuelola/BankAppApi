<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner(){
         return $this->belongsTo(User::class,'user_id');
    }

    public function account(){
         return $this->belongsTo(Account::class,'account_id');
    }
}

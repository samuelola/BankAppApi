<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function owner(){
         return $this->belongsTo(User::class,'user_id');
    }

    public function transactions(){
         return $this->hasMany(Transaction::class);
    }
}

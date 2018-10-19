<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id'];
    public $incrementing = false;
    protected $primaryKey = ['user_id', 'likeable_id', 'likeable_type'];
}

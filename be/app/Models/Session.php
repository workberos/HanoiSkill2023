<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ['room_id', 'title', 'description', 'speaker', 'start', 'end', 'type', 'cost'];
    public $hidden = ['room_id'];

}

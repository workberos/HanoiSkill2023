<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ['name', 'channel_id', 'capacity'];
    public $hidden = ['channel_id', 'capacity'];
    public $appends = ['sessions'];

    public function getSessionsAttribute() {
        return Session::where('room_id', $this->id)->get();
    }

    public function sessions() {
        return $this->hasMany(Session::class, 'room_id', 'id');
    }
}

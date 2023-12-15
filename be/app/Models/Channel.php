<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    public $hidden = ['event_id'];
    public $appends = ['rooms'];


    public function getRoomsAttribute() {
        return Room::where('channel_id', $this->id)->get();
    }
    public function rooms() {
        return $this->hasMany(Room::class, 'channel_id', 'id');
    }
}

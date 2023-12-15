<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;
    public $fillable = ['login_token'];
    public $hidden = ['login_token'];
    public $appends = ['token'];

    public function getTokenAttribute() {
        return $this->login_token;
    }
}

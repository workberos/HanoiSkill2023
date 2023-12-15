<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_ticket extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ['event_id', 'name', 'cost', 'special_validity'];
    public $hidden = ['event_id', 'special_validity'];
    public $appends = ['desciption', 'available'];
    public function getDesciptionAttribute() {
        $des = json_decode($this ->special_validity);
        if($des != null ) {
            if ($des->type == 'date'){
                return "Có sẵn đến ngày ".date('d-m-Y', strtotime($des->date));
            }
            else{
                return $des->amount.' vé sẵn có';
            }
        }
        return $des;
    }
    public function getAvailableAttribute() {

        return !!$this ->special_validity;
    }


}

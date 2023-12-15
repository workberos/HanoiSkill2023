<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ['attendee_id', 'ticket_id', 'registration_time'];
    public $hidden = ['id', 'attendee_id', 'ticket_id', 'registration_time'];
    public $appends = ['event', 'session_ids'];
    public function getEventAttribute() {
        $ticket = Event_ticket::find($this->ticket_id);
        $event = Event::where('id', $ticket->event_id)
        ->with('organizer')
        ->get();
        return $event;
    }

    public function getSessionIdsAttribute() {
        return Session_registration::where('registration_id', $this->id)
        ->get()->pluck('session_id');
    }

}

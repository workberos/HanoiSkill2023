<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function create(Event $event)
    {
        return view('rooms.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required'
        ]);
        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'channel_id' => $request->channel,


        ]);
        return redirect()->route('event.show', $event)
        ->with('message', 'Tạo phòng thành công');
    }

 
}

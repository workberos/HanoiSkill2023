<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('sessions.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'speaker' => 'required',
            'cost' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        Session::create([
            'room_id' => $request->room
        ]);

        return redirect()->route('event.show', $event)
        ->with('message', 'Phiên được tạo thành công');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Session $session)
    {
        
        return view('sessions.edit', compact('session', 'event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Event $event, Session $session)
    {
        $session->update($request->all());
        return redirect()->route('event.show', $event)
        ->with('message', 'Phiên cập nhật thành công');

    }
}

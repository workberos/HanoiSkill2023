<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('organizer_id', session('organizer')->id)
                ->orderBy('date', 'asc')
                ->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $message = [
        'slug.required' => 'slug không được để trống',
        'slug.unique' => 'slug đã tồn tại',
        'date.required' => 'date không được để trống',
        'date.date_format' => 'date không đúng định dạng',



       ];
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:events',
            'date' => 'required|date_format:Y-m-d',
        ], $message);

        $event = Event::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'date' => $request->date,
            'organizer_id' => session('organizer')->id
        ]);


        return redirect()->route('event.show', $event)
                ->with('message', 'Tạo sự kiện thành công');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.detail', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event = Event::where('id', $event->id)->first();
        $event->update($request->all());

        return redirect()->route('event.show', $event)
        ->with('message', 'Cập nhật sự kiện thành công');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}

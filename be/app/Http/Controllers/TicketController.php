<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        // dd($request);
        // $ticket = Event_ticket::create(

        // )
        $hieuluc = '';
        $special_validity = '';
        if($request->special_validity == 'amount') {
            $hieuluc = 'amount';
            $special_validity = json_encode(['type' => 'amount', 'amount' => $request->amount ]);
        }
        if($request->special_validity == 'date') {
            $hieuluc = 'valid_until';
            $special_validity = json_encode(['type' => 'date', 'date' => $request->valid_until ]);

        }
        $message = [
            'name.required' => 'Tên không được để trống',
            'cost.required' => 'Cost không được để trống',
            'amount.required' => 'Số lượng không được để trống',
            'date.required' => 'Date không được để trống',
        ];
        $request->validate([
            'name' =>'required',
            'cost' =>'required',
            $hieuluc =>'required',
        ], $message);

        
        $ticket = Event_ticket::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'cost' => $request->cost,
            'special_validity' => $special_validity
        ]);


        return redirect()->route('event.show', $event)->with(['message' => 'Vé được tạo thành công']);
    }

   
}

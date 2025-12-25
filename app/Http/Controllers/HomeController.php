<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::with('ticket')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('ticket');
        return view('events.show', compact('event'));
    }
}

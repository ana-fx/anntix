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
        $events = Event::with('tickets')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $banners = \App\Models\Banner::where('is_active', true)->latest()->get();

        return view('home', compact('events', 'banners'));
    }

    public function show(Event $event)
    {
        $event->load('tickets');

        $relatedEvents = Event::where('status', 'active')
            ->where('id', '!=', $event->id)
            ->with([
                'tickets' => function ($query) {
                    $query->where('start_date', '<=', now())
                        ->where('end_date', '>=', now())
                        ->orderBy('price', 'asc');
                }
            ])
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}

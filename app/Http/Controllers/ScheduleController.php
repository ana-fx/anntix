<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Fetch upcoming events ordered by start date
        $events = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get()
            ->groupBy(function ($event) {
                return $event->start_date->format('Y-m-d');
            });

        return view('schedule.index', compact('events'));
    }
}

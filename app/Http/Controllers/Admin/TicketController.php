<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class TicketController extends Controller
{

    public function list()
    {
        $tickets = Ticket::with('event')->latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function index(Event $event)
    {
        // Get the single ticket for this event
        $ticket = $event->ticket;
        $tickets = $ticket ? collect([$ticket]) : collect();
        return view('admin.tickets.index', compact('event', 'tickets'));
    }

    public function create(Event $event)
    {
        if ($event->ticket()->exists()) {
            return redirect()->route('admin.events.index')
                ->with('error', 'This event already has a ticket. Only 1 ticket per event is allowed.');
        }
        return view('admin.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        if ($event->ticket()->exists()) {
            return redirect()->route('admin.events.index')
                ->with('error', 'This event already has a ticket.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'max_purchase_per_user' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required|string',
        ]);

        $event->ticket()->create($validated);

        // Redirect back to event index or ticket index? 
        // "after create event can you update to create ticket" -> user flow continues.
        // Maybe redirect to the event index with success?
        // Or redirect to the ticket list for this event.
        // Let's redirect to the event list for now or keep them on the ticket page.
        // Usually, after adding a ticket, you might want to add another.
        // Let's redirect to event index saying ticket created.

        return redirect()->route('admin.events.index')->with('success', 'Ticket created successfully.');
    }

    public function edit(Ticket $ticket)
    {
        $event = $ticket->event;
        return view('admin.tickets.edit', compact('ticket', 'event'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'max_purchase_per_user' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Ticket deleted successfully.');
    }
}

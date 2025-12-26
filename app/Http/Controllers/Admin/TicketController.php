<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{




    public function create(Event $event)
    {
        return view('admin.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'max_purchase_per_user' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required|string',
        ]);

        $event->tickets()->create($validated);

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

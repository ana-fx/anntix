<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    protected function getOrganizerEvents()
    {
        return Event::where('organizer_id', Auth::id());
    }


    /**
     * List events assigned to this organizer by admin.
     */
    public function index()
    {
        $events = $this->getOrganizerEvents()
            ->withCount(['tickets', 'scanners', 'resellers'])
            ->latest()
            ->paginate(15);

        return view('organizer.events.index', compact('events'));
    }

    /**
     * Show event detail + its tickets.
     */
    public function show(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        $event->load(['tickets', 'scanners', 'resellers']);

        return view('organizer.events.show', compact('event'));
    }

    public function scanners(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load('scanners');
        return view('organizer.events.scanners.index', compact('event'));
    }

    public function resellers(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load('resellers');
        return view('organizer.events.resellers.index', compact('event'));
    }

    /**
     * Show edit form.
     */
    public function edit(Event $event)
    {
        $this->authorizeEvent($event);
        return view('organizer.events.edit', compact('event'));
    }

    /**
     * Update event info (name, description, location, dates, etc.)
     * Organizers cannot change organizer_id or status beyond their scope.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'nullable|string|max:100',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after:start_date',
            'description'      => 'nullable|string',
            'terms'            => 'nullable|string',
            'location'         => 'nullable|string|max:255',
            'province'         => 'nullable|string|max:100',
            'city'             => 'nullable|string|max:100',
            'zip'              => 'nullable|string|max:20',
            'google_map_embed' => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'seo_description'  => 'nullable|string',
            'organizer_name'   => 'nullable|string|max:255',
            'banner'           => 'nullable|image|max:2048',
            'thumbnail'        => 'nullable|image|max:2048',
            'organizer_logo'   => 'nullable|image|max:2048',
            'is_online_sales_enabled' => 'nullable|boolean',
        ]);

        // Specific fields that organizers might be allowed to toggle if admin permits,
        // but for now we follow the admin edit view fields.
        if ($request->has('is_online_sales_enabled')) {
            $validated['is_online_sales_enabled'] = $request->is_online_sales_enabled;
        }

        foreach (['banner' => 'banner_path', 'thumbnail' => 'thumbnail_path', 'organizer_logo' => 'organizer_logo_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                if ($event->$column && !Str::startsWith($event->$column, 'http')) {
                    Storage::disk('public')->delete($event->$column);
                }
                $validated[$column] = $request->file($input)->store('events', 'public');
            }
            unset($validated[$input]);
        }

        $event->update($validated);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    protected function authorizeEvent(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'You are not assigned to this event.');
        }
    }
}

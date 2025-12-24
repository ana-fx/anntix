<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|in:draft,published,ended',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required|string',
            'terms' => 'nullable|string',
            'location' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'organizer_name' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
            'thumbnail' => 'nullable|image|max:2048',
            'organizer_photo' => 'nullable|image|max:1024',
        ]);

        $slug = Str::slug($validated['name']);
        // Ensure unique slug
        $count = Event::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $validated['slug'] = $slug;

        // Handle File Uploads
        if ($request->hasFile('banner')) {
            $validated['banner_path'] = $request->file('banner')->store('events/banners', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('events/thumbnails', 'public');
        }
        if ($request->hasFile('organizer_photo')) {
            $validated['organizer_photo_path'] = $request->file('organizer_photo')->store('events/organizers', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|in:draft,published,ended',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required|string',
            'terms' => 'nullable|string',
            'location' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'organizer_name' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
            'thumbnail' => 'nullable|image|max:2048',
            'organizer_photo' => 'nullable|image|max:1024',
        ]);

        // Regenerate slug if name changed
        if ($event->name !== $validated['name']) {
             $slug = Str::slug($validated['name']);
             $count = Event::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $event->id)->count();
             if ($count > 0) {
                 $slug .= '-' . ($count + 1);
             }
             $validated['slug'] = $slug;
        }

        if ($request->hasFile('banner')) {
            if ($event->banner_path) Storage::disk('public')->delete($event->banner_path);
            $validated['banner_path'] = $request->file('banner')->store('events/banners', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail_path) Storage::disk('public')->delete($event->thumbnail_path);
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('events/thumbnails', 'public');
        }
        if ($request->hasFile('organizer_photo')) {
            if ($event->organizer_photo_path) Storage::disk('public')->delete($event->organizer_photo_path);
            $validated['organizer_photo_path'] = $request->file('organizer_photo')->store('events/organizers', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->banner_path) Storage::disk('public')->delete($event->banner_path);
        if ($event->thumbnail_path) Storage::disk('public')->delete($event->thumbnail_path);
        if ($event->organizer_photo_path) Storage::disk('public')->delete($event->organizer_photo_path);

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}

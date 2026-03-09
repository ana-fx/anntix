<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class OrganizerUserController extends Controller
{
    public function index()
    {
        $organizers = User::where('role', 'organizer')->latest()->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'organizer',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer created successfully.');
    }

    public function edit(User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            return back()->with('error', 'Invalid user role.');
        }
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            return back()->with('error', 'Cannot edit this user.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($organizer->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $organizer->profile_photo_path = $path;
        }

        $organizer->name = $validated['name'];
        $organizer->email = $validated['email'];
        $organizer->phone = $validated['phone'];
        $organizer->bio = $validated['bio'];
        $organizer->address = $validated['address'];

        if (!empty($validated['password'])) {
            $organizer->password = Hash::make($validated['password']);
        }

        $organizer->save();

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer updated successfully.');
    }

    public function destroy(User $organizer)
    {
        if ($organizer->role !== 'organizer') {
            return back()->with('error', 'Cannot delete this user.');
        }

        // Technically organizers can't delete themselves if they don't have access to this panel,
        // but adding for safety.
        if ($organizer->id === Auth::id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $organizer->delete();
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer deleted successfully.');
    }
}

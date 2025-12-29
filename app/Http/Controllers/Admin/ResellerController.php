<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = User::where('role', 'reseller')->latest()->paginate(10);
        return view('admin.resellers.index', compact('resellers'));
    }

    public function create()
    {
        return view('admin.resellers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        $reseller = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'reseller',
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'address' => $validated['address'] ?? null,
            'email_verified_at' => now(),
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $reseller->profile_photo_path = $path;
            $reseller->save();
        }

        return redirect()->route('admin.resellers.index')->with('success', 'Reseller created successfully.');
    }

    public function edit(User $reseller)
    {
        if ($reseller->role !== 'reseller') {
            return back()->with('error', 'Invalid user role.');
        }
        return view('admin.resellers.edit', compact('reseller'));
    }

    public function update(Request $request, User $reseller)
    {
        if ($reseller->role !== 'reseller') {
            return back()->with('error', 'Cannot edit this user.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($reseller->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $reseller->profile_photo_path = $path;
        }

        $reseller->name = $validated['name'];
        $reseller->email = $validated['email'];
        $reseller->phone = $validated['phone'];
        $reseller->bio = $validated['bio'];
        $reseller->address = $validated['address'];

        if (!empty($validated['password'])) {
            $reseller->password = Hash::make($validated['password']);
        }

        $reseller->save();

        return redirect()->route('admin.resellers.index')->with('success', 'Reseller updated successfully.');
    }

    public function destroy(User $reseller)
    {
        if ($reseller->role !== 'reseller') {
            return back()->with('error', 'Cannot delete this user.');
        }

        $reseller->delete();
        return redirect()->route('admin.resellers.index')->with('success', 'Reseller deleted successfully.');
    }
}

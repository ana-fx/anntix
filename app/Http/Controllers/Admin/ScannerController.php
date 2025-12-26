<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ScannerController extends Controller
{
    public function index()
    {
        $scanners = User::where('role', 'scanner')->latest()->paginate(10);
        return view('admin.scanners.index', compact('scanners'));
    }

    public function create()
    {
        return view('admin.scanners.create');
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
            'role' => 'scanner',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.scanners.index')->with('success', 'Scanner created successfully.');
    }

    public function edit(User $scanner)
    {
        if ($scanner->role !== 'scanner') {
            return back()->with('error', 'Invalid user role.');
        }
        return view('admin.scanners.edit', compact('scanner'));
    }

    public function update(Request $request, User $scanner)
    {
        if ($scanner->role !== 'scanner') {
            return back()->with('error', 'Cannot edit this user.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($scanner->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $scanner->name = $validated['name'];
        $scanner->email = $validated['email'];

        if (!empty($validated['password'])) {
            $scanner->password = Hash::make($validated['password']);
        }

        $scanner->save();

        return redirect()->route('admin.scanners.index')->with('success', 'Scanner updated successfully.');
    }

    public function destroy(User $scanner)
    {
        if ($scanner->role !== 'scanner') {
            return back()->with('error', 'Cannot delete this user.');
        }

        $scanner->delete();
        return redirect()->route('admin.scanners.index')->with('success', 'Scanner deleted successfully.');
    }
}

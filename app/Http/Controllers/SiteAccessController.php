<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteAccessController extends Controller
{
    public function index()
    {
        if (session()->get('site_accessible')) {
            return redirect()->route('home');
        }
        return view('site-access');
    }

    public function unlock(Request $request)
    {
        $password = config('app.site_password');

        if ($request->password === $password) {
            session(['site_accessible' => true]);
            return redirect()->route('home');
        }

        return back()->with('error', 'Incorrect password. Access denied.');
    }
}

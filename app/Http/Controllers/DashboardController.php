<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_draws' => $user->draws()->count(),
            'total_participants' => $user->draws()->sum('participant_count'),
            'draws_this_month' => $user->draws()->whereMonth('created_at', now()->month)->count(),
            'recent_draws' => $user->draws()->latest()->take(5)->get(),
        ];
        
        return view('dashboard', compact('stats'));
    }
}

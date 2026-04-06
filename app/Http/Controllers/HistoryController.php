<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->draws()->latest();
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $draws = $query->paginate(20);
        
        return view('history', compact('draws'));
    }
}

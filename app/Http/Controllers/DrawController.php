<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Services\ExportService;
use Illuminate\Http\Request;

class DrawController extends Controller
{
    public function __construct(private ExportService $exportService)
    {}

    public function create()
    {
        return view('draw.create');
    }

    public function show(Draw $draw)
    {
        // Vérifier que l'utilisateur est propriétaire du tirage
        if ($draw->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        
        $draw->load(['participants', 'constraints']);
        
        return view('draw.show', compact('draw'));
    }

    public function downloadPdf(Draw $draw)
    {
        // Vérifier que l'utilisateur est propriétaire du tirage
        if ($draw->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        
        return $this->exportService->generatePdf($draw);
    }

    public function downloadExcel(Draw $draw)
    {
        // Vérifier que l'utilisateur est propriétaire du tirage
        if ($draw->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        
        return $this->exportService->generateExcel($draw);
    }
}

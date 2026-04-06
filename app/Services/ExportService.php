<?php

namespace App\Services;

use App\Models\Draw;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DrawExport;

class ExportService
{
    public function generatePdf(Draw $draw)
    {
        $draw->load(['participants', 'constraints', 'user']);
        
        $groups = $draw->type === 'A' 
            ? $draw->participants->groupBy('group_id')
            : $draw->participants->groupBy('theme_name');
        
        $pdf = Pdf::loadView('exports.draw-pdf', compact('draw', 'groups'));
        
        $filename = 'tirage_' . $draw->id . '_' . now()->format('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function generateExcel(Draw $draw)
    {
        $filename = 'tirage_' . $draw->id . '_' . now()->format('Ymd_His') . '.xlsx';
        
        return Excel::download(new DrawExport($draw), $filename);
    }
}

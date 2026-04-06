<?php

namespace App\Exports;

use App\Models\Draw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DrawExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $draw;

    public function __construct(Draw $draw)
    {
        $this->draw = $draw;
        $this->draw->load('participants');
    }

    public function collection()
    {
        return $this->draw->participants->map(function ($participant) {
            return [
                'nom' => $participant->full_name,
                'groupe' => $this->draw->type === 'A' ? 'Groupe ' . $participant->group_id : $participant->theme_name,
                'position' => $participant->position_in_draw + 1,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nom complet', $this->draw->type === 'A' ? 'Groupe' : 'Thème', 'Position tirage'];
    }

    public function title(): string
    {
        return substr($this->draw->title, 0, 31);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

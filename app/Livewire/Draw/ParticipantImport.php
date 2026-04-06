<?php

namespace App\Livewire\Draw;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\DrawService;

class ParticipantImport extends Component
{
    use WithFileUploads;

    public $file;
    public $pastedText = '';
    public $participants = [];
    public $title = '';
    public $duplicatePairs = [];
    
    protected $rules = [
        'title' => 'required|string|max:255|min:3',
        'participants' => 'required|array|min:2',
    ];

    protected $messages = [
        'title.required' => 'Le titre du tirage est obligatoire.',
        'title.min' => 'Le titre doit contenir au moins 3 caractères.',
        'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
        'participants.required' => 'Veuillez importer au moins 2 participants.',
        'participants.min' => 'Un tirage nécessite au moins 2 participants.',
    ];

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ], [
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.mimes' => 'Le fichier doit être au format CSV, XLS ou XLSX.',
            'file.max' => 'Le fichier ne doit pas dépasser 2 Mo.',
        ]);
        
        try {
            $path = $this->file->getRealPath();
            $extension = $this->file->getClientOriginalExtension();
            
            if ($extension === 'csv') {
                $this->importCsv($path);
            } else {
                $this->importExcel($path);
            }
            
            $this->cleanParticipants();
            $this->checkDuplicates();
            
            session()->flash('success', count($this->participants) . ' participants importés avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
            $this->participants = [];
        }
    }

    private function importCsv(string $path): void
    {
        $data = array_map('str_getcsv', file($path));
        
        // Détecter la colonne des noms (première colonne non vide)
        $names = [];
        foreach ($data as $row) {
            if (!empty($row[0]) && trim($row[0]) !== '') {
                $names[] = trim($row[0]);
            }
        }
        
        // Retirer la première ligne si c'est un header
        if (!empty($names) && (stripos($names[0], 'nom') !== false || stripos($names[0], 'name') !== false)) {
            array_shift($names);
        }
        
        $this->participants = $names;
    }

    private function importExcel(string $path): void
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        $names = [];
        foreach ($rows as $row) {
            if (!empty($row[0]) && trim($row[0]) !== '') {
                $names[] = trim($row[0]);
            }
        }
        
        // Retirer header
        if (!empty($names) && (stripos($names[0], 'nom') !== false || stripos($names[0], 'name') !== false)) {
            array_shift($names);
        }
        
        $this->participants = $names;
    }

    public function updatedPastedText()
    {
        $lines = explode("\n", $this->pastedText);
        $this->participants = array_filter(array_map('trim', $lines));
        
        $this->cleanParticipants();
        $this->checkDuplicates();
    }

    public function cleanParticipants()
    {
        $this->participants = array_values(array_unique(array_filter($this->participants)));
    }

    public function checkDuplicates()
    {
        $drawService = app(DrawService::class);
        $this->duplicatePairs = $drawService->detectDuplicatePairs(auth()->id(), $this->participants);
    }

    public function removeParticipant($index)
    {
        unset($this->participants[$index]);
        $this->participants = array_values($this->participants);
    }

    public function nextStep()
    {
        $this->validate();
        
        session([
            'draw_title' => $this->title,
            'draw_participants' => $this->participants,
        ]);
        
        $this->dispatch('step-completed', step: 1);
    }

    public function render()
    {
        return view('livewire.draw.participant-import');
    }
}

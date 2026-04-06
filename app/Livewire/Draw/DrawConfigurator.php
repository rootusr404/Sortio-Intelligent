<?php

namespace App\Livewire\Draw;

use Livewire\Component;
use App\Services\ShuffleService;
use App\Services\ConstraintService;

class DrawConfigurator extends Component
{
    public $participants = [];
    public $title = '';
    public $mode = 'A';
    public $groupSize;
    public $themes = [];
    public $themeInput = '';
    public $constraints = [];
    public $suggestions = [];
    
    protected $rules = [
        'mode' => 'required|in:A,B',
        'groupSize' => 'required_if:mode,A|integer|min:2',
        'themes' => 'required_if:mode,B|array|min:2',
    ];

    protected $messages = [
        'mode.required' => 'Veuillez sélectionner un mode de tirage.',
        'mode.in' => 'Le mode sélectionné n\'est pas valide.',
        'groupSize.required_if' => 'La taille des groupes est obligatoire pour le Mode A.',
        'groupSize.integer' => 'La taille doit être un nombre entier.',
        'groupSize.min' => 'Les groupes doivent contenir au moins 2 personnes.',
        'themes.required_if' => 'Veuillez définir au moins 2 thèmes pour le Mode B.',
        'themes.min' => 'Le Mode B nécessite au moins 2 thèmes.',
    ];

    public function mount()
    {
        $this->participants = session('draw_participants', []);
        $this->title = session('draw_title', '');
        
        $this->calculateSuggestions();
    }

    public function calculateSuggestions()
    {
        $shuffleService = app(ShuffleService::class);
        $this->suggestions = $shuffleService->suggestOptimalGroupSizes(count($this->participants));
    }

    public function selectSuggestion($size)
    {
        $this->groupSize = $size;
    }

    public function addTheme()
    {
        if (!empty($this->themeInput)) {
            $this->themes[] = trim($this->themeInput);
            $this->themeInput = '';
        }
    }

    public function removeTheme($index)
    {
        unset($this->themes[$index]);
        $this->themes = array_values($this->themes);
    }

    public function addConstraint($type, $participant1, $participant2)
    {
        if (count($this->constraints) >= 20) {
            session()->flash('error', 'Maximum 20 contraintes par tirage');
            return;
        }
        
        $this->constraints[] = [
            'type' => $type,
            'participant_ids' => [$participant1, $participant2],
        ];
    }

    public function removeConstraint($index)
    {
        unset($this->constraints[$index]);
        $this->constraints = array_values($this->constraints);
    }

    public function nextStep()
    {
        try {
            // Validation conditionnelle selon le mode
            if ($this->mode === 'A') {
                $this->validate([
                    'mode' => 'required|in:A,B',
                    'groupSize' => 'required|integer|min:2',
                ]);
                
                if ($this->groupSize > count($this->participants)) {
                    $this->addError('groupSize', "La taille des groupes ({$this->groupSize}) ne peut pas dépasser le nombre de participants (" . count($this->participants) . ").");
                    return;
                }
            } else {
                $this->validate([
                    'mode' => 'required|in:A,B',
                    'themes' => 'required|array|min:2',
                ]);
                
                if (count($this->themes) > count($this->participants)) {
                    $this->addError('themes', "Le nombre de thèmes (" . count($this->themes) . ") ne peut pas dépasser le nombre de participants (" . count($this->participants) . ").");
                    return;
                }
            }
            
            $parameters = $this->mode === 'A' 
                ? ['group_size' => $this->groupSize]
                : ['themes' => $this->themes];
            
            // Exécuter le tirage immédiatement
            $drawService = app(\App\Services\DrawService::class);
            
            $draw = $drawService->executeDraw(
                auth()->id(),
                $this->title,
                $this->mode,
                $this->participants,
                $parameters,
                $this->constraints
            );
            
            // Nettoyer la session
            session()->forget(['draw_title', 'draw_participants', 'draw_mode', 'draw_parameters', 'draw_constraints']);
            
            // Rediriger vers la page de résultats
            return redirect()->route('draw.show', $draw);
            
        } catch (\Exception $e) {
            $this->addError('general', 'Erreur: ' . $e->getMessage());
        }
    }

    public function previousStep()
    {
        $this->dispatch('step-back', step: 1);
    }

    public function render()
    {
        return view('livewire.draw.draw-configurator');
    }
}

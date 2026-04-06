<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class RegisterStep2 extends Component
{
    public $context = '';
    public $role = '';
    public $organization = '';
    public $typical_group_size = '';
    public $draw_frequency = '';
    
    public $contexts = [
        'edu' => 'Éducation',
        'enterprise' => 'Entreprise',
        'association' => 'Association',
        'personal' => 'Usage personnel',
    ];
    
    public $roles = [
        'edu' => [
            'Professeur/Enseignant',
            'Formateur/Instructeur',
            'Chef de classe/Délégué',
            'Directeur pédagogique',
            'Coordinateur de formation',
        ],
        'enterprise' => [
            'Chef de projet',
            'Manager d\'équipe',
            'Responsable RH/Formation',
            'Directeur/Cadre supérieur',
        ],
        'association' => [
            'Président/Secrétaire général',
            'Organisateur d\'événement',
            'Responsable bénévoles',
            'Animateur/Facilitateur',
        ],
        'personal' => [
            'Étudiant organisateur',
            'Usage personnel',
            'Autre',
        ],
    ];
    
    protected $rules = [
        'context' => 'required|in:edu,enterprise,association,personal',
        'role' => 'required|string|max:150',
        'organization' => 'nullable|string|max:255',
        'typical_group_size' => 'nullable|in:less_20,20_50,50_100,more_100',
        'draw_frequency' => 'nullable|in:occasional,monthly,weekly,daily',
    ];

    protected $messages = [
        'context.required' => 'Veuillez sélectionner votre secteur d\'activité.',
        'context.in' => 'Le secteur sélectionné n\'est pas valide.',
        'role.required' => 'Veuillez sélectionner votre rôle.',
        'role.max' => 'Le rôle ne peut pas dépasser 150 caractères.',
        'organization.max' => 'Le nom de l\'organisation ne peut pas dépasser 255 caractères.',
    ];

    public function mount()
    {
        $step1 = session('register_step1');
        if (!$step1) {
            return redirect()->route('register');
        }
    }

    public function nextStep()
    {
        $this->validate();
        
        session([
            'register_step2' => [
                'context' => $this->context,
                'role' => $this->role,
                'organization' => trim($this->organization),
                'typical_group_size' => $this->typical_group_size,
                'draw_frequency' => $this->draw_frequency,
            ]
        ]);
        
        $this->dispatch('step-completed', step: 2);
    }

    public function previousStep()
    {
        $this->dispatch('step-back', step: 1);
    }

    public function render()
    {
        return view('livewire.auth.register-step2');
    }
}

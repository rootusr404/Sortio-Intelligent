<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;

class RegisterStep1 extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $country = 'BF';
    public $city = '';
    public $emailAvailable = null;
    
    public $countries = [
        'BF' => ['name' => 'Burkina Faso', 'code' => '+226'],
        'CI' => ['name' => 'Côte d\'Ivoire', 'code' => '+225'],
        'SN' => ['name' => 'Sénégal', 'code' => '+221'],
        'ML' => ['name' => 'Mali', 'code' => '+223'],
        'CM' => ['name' => 'Cameroun', 'code' => '+237'],
        'FR' => ['name' => 'France', 'code' => '+33'],
    ];
    
    protected $rules = [
        'first_name' => 'required|string|max:100|min:2',
        'last_name' => 'required|string|max:100|min:2',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'country' => 'required|string',
        'city' => 'nullable|string|max:100',
    ];

    protected $messages = [
        'first_name.required' => 'Le prénom est obligatoire.',
        'first_name.min' => 'Le prénom doit contenir au moins 2 caractères.',
        'first_name.max' => 'Le prénom ne peut pas dépasser 100 caractères.',
        'last_name.required' => 'Le nom est obligatoire.',
        'last_name.min' => 'Le nom doit contenir au moins 2 caractères.',
        'last_name.max' => 'Le nom ne peut pas dépasser 100 caractères.',
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée. Essayez de vous connecter.',
        'phone.max' => 'Le numéro de téléphone est trop long.',
        'country.required' => 'Veuillez sélectionner votre pays.',
        'city.max' => 'Le nom de la ville ne peut pas dépasser 100 caractères.',
    ];

    public function updatedEmail()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $exists = User::where('email', $this->email)->exists();
            $this->emailAvailable = !$exists;
            
            if ($exists) {
                $this->addError('email', 'Cette adresse email est déjà utilisée.');
            }
        } else {
            $this->emailAvailable = null;
        }
    }

    public function nextStep()
    {
        $this->validate();
        
        session([
            'register_step1' => [
                'first_name' => trim($this->first_name),
                'last_name' => trim($this->last_name),
                'email' => strtolower(trim($this->email)),
                'phone' => $this->phone,
                'country' => $this->country,
                'city' => $this->city,
            ]
        ]);
        
        $this->dispatch('step-completed', step: 1);
    }

    public function render()
    {
        return view('livewire.auth.register-step1');
    }
}

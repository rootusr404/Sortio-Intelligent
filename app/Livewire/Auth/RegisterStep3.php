<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterStep3 extends Component
{
    public $password = '';
    public $password_confirmation = '';
    public $plan = 'free';
    public $accept_terms = false;
    public $accept_gdpr = false;
    public $newsletter = false;
    public $passwordStrength = 0;
    
    protected function rules()
    {
        return [
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
            'plan' => 'required|in:free,pro',
            'accept_terms' => 'accepted',
            'accept_gdpr' => 'accepted',
        ];
    }

    protected $messages = [
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        'plan.required' => 'Veuillez sélectionner un plan.',
        'plan.in' => 'Le plan sélectionné n\'est pas valide.',
        'accept_terms.accepted' => 'Vous devez accepter les Conditions Générales d\'Utilisation.',
        'accept_gdpr.accepted' => 'Vous devez accepter le traitement de vos données conformément au RGPD.',
    ];

    public function mount()
    {
        $step1 = session('register_step1');
        $step2 = session('register_step2');
        
        if (!$step1 || !$step2) {
            session()->flash('error', 'Session expirée. Veuillez recommencer l\'inscription.');
            return redirect()->route('register');
        }
    }

    public function updatedPassword()
    {
        $strength = 0;
        $password = $this->password;
        
        if (strlen($password) >= 8) $strength++;
        if (preg_match('/[a-z]/', $password)) $strength++;
        if (preg_match('/[A-Z]/', $password)) $strength++;
        if (preg_match('/[0-9]/', $password)) $strength++;
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $strength++;
        
        $this->passwordStrength = $strength;
    }

    public function register()
    {
        $this->validate();
        
        $step1 = session('register_step1');
        $step2 = session('register_step2');
        
        if (!$step1 || !$step2) {
            session()->flash('error', 'Session expirée. Veuillez recommencer l\'inscription.');
            return redirect()->route('register');
        }
        
        try {
            $user = User::create([
                'first_name' => $step1['first_name'],
                'last_name' => $step1['last_name'],
                'email' => $step1['email'],
                'phone' => $step1['phone'],
                'country' => $step1['country'],
                'city' => $step1['city'],
                'context' => $step2['context'],
                'role' => $step2['role'],
                'organization' => $step2['organization'],
                'typical_group_size' => $step2['typical_group_size'],
                'draw_frequency' => $step2['draw_frequency'],
                'plan' => $this->plan,
                'password' => Hash::make($this->password),
            ]);
            
            session()->forget(['register_step1', 'register_step2']);
            
            Auth::login($user);
            
            session()->flash('success', 'Bienvenue sur Sortio ! Votre compte a été créé avec succès.');
            
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.');
            return;
        }
    }

    public function previousStep()
    {
        $this->dispatch('step-back', step: 2);
    }

    public function render()
    {
        return view('livewire.auth.register-step3');
    }
}

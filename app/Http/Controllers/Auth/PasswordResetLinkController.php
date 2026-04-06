<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.exists' => 'Aucun compte n\'existe avec cette adresse email.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        }

        if ($status == Password::RESET_THROTTLED) {
            return back()->withErrors(['email' => 'Veuillez patienter avant de demander un nouveau lien.']);
        }

        return back()->withErrors(['email' => 'Impossible d\'envoyer le lien de réinitialisation. Veuillez réessayer.']);
    }
}

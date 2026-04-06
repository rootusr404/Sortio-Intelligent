<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HashService;

class VerifyController extends Controller
{
    public function __construct(private HashService $hashService)
    {}

    public function index()
    {
        return view('verify');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'hash' => ['required', 'string', 'size:64'],
            'seed' => ['required', 'string'],
            'timestamp' => ['required', 'string'],
            'participants' => ['required', 'string'],
            'draw_type' => ['required', 'in:A,B'],
            'group_size' => ['nullable', 'integer', 'min:2'],
            'themes' => ['nullable', 'string'],
        ], [
            'hash.required' => 'Le hash SHA-256 est obligatoire.',
            'hash.size' => 'Le hash doit contenir exactement 64 caractères.',
            'seed.required' => 'Le seed est obligatoire.',
            'timestamp.required' => 'Le timestamp est obligatoire.',
            'participants.required' => 'La liste des participants est obligatoire.',
            'draw_type.required' => 'Le type de tirage est obligatoire.',
            'draw_type.in' => 'Le type de tirage doit être A ou B.',
            'group_size.integer' => 'La taille des groupes doit être un nombre entier.',
            'group_size.min' => 'La taille des groupes doit être au moins 2.',
        ]);
        
        // Validation conditionnelle
        if ($request->draw_type === 'A') {
            if (empty($request->group_size)) {
                return back()->withErrors(['group_size' => 'La taille des groupes est obligatoire pour le Mode A.'])->withInput();
            }
        } else {
            if (empty($request->themes)) {
                return back()->withErrors(['themes' => 'Les thèmes sont obligatoires pour le Mode B.'])->withInput();
            }
        }

        try {
            // Parser les participants (un par ligne)
            $participantsList = array_filter(array_map('trim', explode("\n", $request->participants)));
            
            if (count($participantsList) < 2) {
                return back()->withErrors(['participants' => 'Vous devez fournir au moins 2 participants.'])->withInput();
            }
            
            // Construire les paramètres selon le type
            if ($request->draw_type === 'A') {
                $parametersArray = ['group_size' => (int) $request->group_size];
            } else {
                $themesList = array_filter(array_map('trim', explode("\n", $request->themes)));
                if (count($themesList) < 2) {
                    return back()->withErrors(['themes' => 'Vous devez fournir au moins 2 thèmes pour le Mode B.'])->withInput();
                }
                $parametersArray = ['themes' => $themesList];
            }

            // Vérifier le hash
            $isValid = $this->hashService->verifyHash(
                $participantsList,
                $request->seed,
                $request->timestamp,
                $parametersArray,
                $request->hash
            );

            // Rediriger vers la page de résultat
            return view('verify-result', [
                'isValid' => $isValid,
                'drawType' => $request->draw_type,
                'participants' => $participantsList,
                'parameters' => $parametersArray,
                'hash' => $request->hash,
                'timestamp' => $request->timestamp,
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la vérification : ' . $e->getMessage()])->withInput();
        }
    }
}

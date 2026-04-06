<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'type' => ['required', 'in:A,B'],
            'participants' => ['required', 'array', 'min:2'],
            'participants.*' => ['required', 'string', 'max:255'],
            'group_size' => ['required_if:type,A', 'nullable', 'integer', 'min:2', 'max:50'],
            'themes' => ['required_if:type,B', 'nullable', 'array', 'min:2'],
            'themes.*' => ['required', 'string', 'max:255'],
            'constraints' => ['nullable', 'array', 'max:20'],
            'constraints.*.type' => ['required', 'in:inclusion,exclusion'],
            'constraints.*.participant_ids' => ['required', 'array', 'min:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du tirage est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 3 caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            
            'type.required' => 'Veuillez sélectionner un mode de tirage (A ou B).',
            'type.in' => 'Le mode de tirage sélectionné n\'est pas valide.',
            
            'participants.required' => 'Veuillez importer au moins 2 participants.',
            'participants.min' => 'Un tirage nécessite au moins 2 participants.',
            'participants.*.required' => 'Tous les participants doivent avoir un nom.',
            'participants.*.max' => 'Le nom d\'un participant ne peut pas dépasser 255 caractères.',
            
            'group_size.required_if' => 'La taille des groupes est obligatoire pour le Mode A.',
            'group_size.integer' => 'La taille des groupes doit être un nombre entier.',
            'group_size.min' => 'Les groupes doivent contenir au moins 2 personnes.',
            'group_size.max' => 'Les groupes ne peuvent pas dépasser 50 personnes.',
            
            'themes.required_if' => 'Veuillez définir au moins 2 thèmes pour le Mode B.',
            'themes.min' => 'Le Mode B nécessite au moins 2 thèmes.',
            'themes.*.required' => 'Tous les thèmes doivent avoir un nom.',
            'themes.*.max' => 'Le nom d\'un thème ne peut pas dépasser 255 caractères.',
            
            'constraints.max' => 'Vous ne pouvez pas ajouter plus de 20 contraintes par tirage.',
            'constraints.*.type.required' => 'Le type de contrainte est obligatoire.',
            'constraints.*.type.in' => 'Le type de contrainte doit être "inclusion" ou "exclusion".',
            'constraints.*.participant_ids.required' => 'Veuillez sélectionner au moins 2 participants pour cette contrainte.',
            'constraints.*.participant_ids.min' => 'Une contrainte nécessite au moins 2 participants.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Vérifier que group_size ne dépasse pas le nombre de participants
            if ($this->type === 'A' && $this->group_size) {
                $participantCount = count($this->participants ?? []);
                if ($this->group_size > $participantCount) {
                    $validator->errors()->add(
                        'group_size',
                        "La taille des groupes ({$this->group_size}) ne peut pas dépasser le nombre de participants ({$participantCount})."
                    );
                }
            }

            // Vérifier que le nombre de thèmes ne dépasse pas le nombre de participants
            if ($this->type === 'B' && $this->themes) {
                $participantCount = count($this->participants ?? []);
                $themeCount = count($this->themes);
                if ($themeCount > $participantCount) {
                    $validator->errors()->add(
                        'themes',
                        "Le nombre de thèmes ({$themeCount}) ne peut pas dépasser le nombre de participants ({$participantCount})."
                    );
                }
            }
        });
    }
}

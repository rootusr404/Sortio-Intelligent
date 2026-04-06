<?php

namespace App\Services;

use App\Models\Draw;
use App\Models\Participant;
use App\Models\DrawHistoryPair;
use Illuminate\Support\Facades\DB;

class DrawService
{
    public function __construct(
        private HashService $hashService,
        private ShuffleService $shuffleService,
        private ConstraintService $constraintService
    ) {}

    public function executeDraw(int $userId, string $title, string $type, array $participants, array $parameters, array $constraints = []): Draw
    {
        return DB::transaction(function () use ($userId, $title, $type, $participants, $parameters, $constraints) {
            // Générer seed et timestamp
            $seed = $this->hashService->generateSeed();
            $timestamp = now()->toIso8601String();
            
            // Mélanger avec Fisher-Yates
            $shuffled = $this->shuffleService->fisherYatesShuffle($participants);
            
            // Distribuer dans les groupes
            $groups = $this->distributeParticipants($shuffled, $type, $parameters);
            
            // Appliquer les contraintes si présentes
            $constraintReport = [];
            if (!empty($constraints)) {
                $groupCount = $type === 'A' 
                    ? floor(count($participants) / $parameters['group_size'])
                    : count($parameters['themes']);
                
                $validationErrors = $this->constraintService->validateConstraints($constraints, count($participants), $groupCount);
                
                if (empty($validationErrors)) {
                    $constraintReport = $this->constraintService->resolveConstraints($groups, $constraints);
                }
            }
            
            // Générer hash
            $hashInput = $this->hashService->buildHashInput($participants, $seed, $timestamp, $parameters);
            $hashCode = $this->hashService->generateHash($hashInput);
            
            // Créer le tirage
            $draw = Draw::create([
                'user_id' => $userId,
                'title' => $title,
                'type' => $type,
                'parameters' => $parameters,
                'participant_count' => count($participants),
                'seed' => $seed,
                'hash_input_snapshot' => $hashInput,
                'hash_code' => $hashCode,
                'locked_at' => now(),
            ]);
            
            // Sauvegarder participants
            $this->saveParticipants($draw, $shuffled, $groups, $type);
            
            // Sauvegarder contraintes
            if (!empty($constraints)) {
                $this->saveConstraints($draw, $constraints, $constraintReport);
            }
            
            // Sauvegarder historique des paires
            $this->saveHistoryPairs($userId, $draw->id, $participants);
            
            return $draw->load(['participants', 'constraints']);
        });
    }

    private function distributeParticipants(array $shuffled, string $type, array $parameters): array
    {
        $groups = [];
        
        if ($type === 'A') {
            $groupSize = $parameters['group_size'];
            $groupCount = floor(count($shuffled) / $groupSize);
            $remainder = count($shuffled) % $groupSize;
            
            $position = 0;
            for ($i = 0; $i < $groupCount; $i++) {
                $groups[$i + 1] = array_slice($shuffled, $position, $groupSize);
                $position += $groupSize;
            }
            
            if ($remainder > 0) {
                $remainingParticipants = array_slice($shuffled, $position);
                foreach ($remainingParticipants as $index => $participant) {
                    $groups[($index % $groupCount) + 1][] = $participant;
                }
            }
        } else {
            $themes = $parameters['themes'];
            $perTheme = floor(count($shuffled) / count($themes));
            
            $position = 0;
            foreach ($themes as $index => $theme) {
                $groups[$theme] = array_slice($shuffled, $position, $perTheme);
                $position += $perTheme;
            }
            
            $remainder = count($shuffled) % count($themes);
            if ($remainder > 0) {
                $remainingParticipants = array_slice($shuffled, $position);
                foreach ($remainingParticipants as $index => $participant) {
                    $themeKey = array_keys($groups)[$index % count($themes)];
                    $groups[$themeKey][] = $participant;
                }
            }
        }
        
        return $groups;
    }

    private function saveParticipants(Draw $draw, array $shuffled, array $groups, string $type): void
    {
        foreach ($shuffled as $position => $name) {
            $groupId = null;
            $themeName = null;
            
            if ($type === 'A') {
                foreach ($groups as $gid => $members) {
                    if (in_array($name, $members)) {
                        $groupId = $gid;
                        break;
                    }
                }
            } else {
                foreach ($groups as $theme => $members) {
                    if (in_array($name, $members)) {
                        $themeName = $theme;
                        break;
                    }
                }
            }
            
            Participant::create([
                'draw_id' => $draw->id,
                'full_name' => $name,
                'group_id' => $groupId,
                'theme_name' => $themeName,
                'position_in_draw' => $position,
            ]);
        }
    }

    private function saveHistoryPairs(int $userId, int $drawId, array $participants): void
    {
        for ($i = 0; $i < count($participants); $i++) {
            for ($j = $i + 1; $j < count($participants); $j++) {
                $pair = [$participants[$i], $participants[$j]];
                sort($pair);
                $pairHash = hash('sha256', implode('|', $pair));
                
                DrawHistoryPair::create([
                    'user_id' => $userId,
                    'draw_id' => $drawId,
                    'participant_pair_hash' => $pairHash,
                ]);
            }
        }
    }

    private function saveConstraints(Draw $draw, array $constraints, array $report): void
    {
        foreach ($constraints as $index => $constraint) {
            $reportItem = $report[$index] ?? null;
            
            \App\Models\Constraint::create([
                'draw_id' => $draw->id,
                'type' => $constraint['type'],
                'participant_ids' => json_encode($constraint['participant_ids']),
                'satisfied' => $reportItem['satisfied'] ?? false,
                'failure_reason' => $reportItem['reason'] ?? null,
            ]);
        }
    }

    public function detectDuplicatePairs(int $userId, array $participants): array
    {
        $duplicates = [];
        
        for ($i = 0; $i < count($participants); $i++) {
            for ($j = $i + 1; $j < count($participants); $j++) {
                $pair = [$participants[$i], $participants[$j]];
                sort($pair);
                $pairHash = hash('sha256', implode('|', $pair));
                
                $exists = DrawHistoryPair::where('user_id', $userId)
                    ->where('participant_pair_hash', $pairHash)
                    ->exists();
                
                if ($exists) {
                    $duplicates[] = $pair;
                }
            }
        }
        
        return $duplicates;
    }
}

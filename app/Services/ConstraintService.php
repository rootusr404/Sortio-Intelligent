<?php

namespace App\Services;

class ConstraintService
{
    public function validateConstraints(array $constraints, int $participantCount, int $groupCount): array
    {
        $errors = [];
        
        // Vérifier les contradictions directes
        foreach ($constraints as $index => $constraint) {
            foreach ($constraints as $otherIndex => $otherConstraint) {
                if ($index >= $otherIndex) continue;
                
                $participants = $constraint['participant_ids'];
                $otherParticipants = $otherConstraint['participant_ids'];
                
                $commonParticipants = array_intersect($participants, $otherParticipants);
                
                if (count($commonParticipants) >= 2) {
                    if ($constraint['type'] === 'inclusion' && $otherConstraint['type'] === 'exclusion') {
                        $errors[] = "Contradiction : les participants " . implode(' et ', $commonParticipants) . " doivent être ensemble ET séparés.";
                    }
                }
            }
        }
        
        // Vérifier les impossibilités structurelles
        $exclusionCount = count(array_filter($constraints, fn($c) => $c['type'] === 'exclusion'));
        if ($exclusionCount > $groupCount) {
            $errors[] = "Impossible de satisfaire {$exclusionCount} contraintes d'exclusion avec seulement {$groupCount} groupes.";
        }
        
        return $errors;
    }

    public function resolveConstraints(array &$groups, array $constraints, int $maxAttempts = 100): array
    {
        $report = [];
        
        foreach ($constraints as $constraint) {
            $satisfied = $this->checkConstraint($groups, $constraint);
            $attempts = 0;
            
            while (!$satisfied && $attempts < $maxAttempts) {
                $satisfied = $this->attemptSwap($groups, $constraint);
                $attempts++;
            }
            
            $report[] = [
                'type' => $constraint['type'],
                'participants' => $constraint['participant_ids'],
                'satisfied' => $satisfied,
                'attempts' => $attempts,
                'reason' => !$satisfied ? 'Impossible à satisfaire après ' . $maxAttempts . ' tentatives' : null,
            ];
        }
        
        return $report;
    }

    private function checkConstraint(array $groups, array $constraint): bool
    {
        $type = $constraint['type'];
        $participantNames = $constraint['participant_ids'];
        
        $groupsContaining = [];
        foreach ($groups as $groupId => $members) {
            foreach ($participantNames as $name) {
                if (in_array($name, $members)) {
                    $groupsContaining[$name] = $groupId;
                }
            }
        }
        
        $uniqueGroups = array_unique(array_values($groupsContaining));
        
        if ($type === 'inclusion') {
            return count($uniqueGroups) === 1;
        } else {
            return count($uniqueGroups) === count($participantNames);
        }
    }

    private function attemptSwap(array &$groups, array $constraint): bool
    {
        $type = $constraint['type'];
        $participantNames = $constraint['participant_ids'];
        
        // Trouver les groupes actuels des participants
        $currentGroups = [];
        foreach ($groups as $groupId => $members) {
            foreach ($participantNames as $name) {
                if (in_array($name, $members)) {
                    $currentGroups[$name] = $groupId;
                }
            }
        }
        
        if ($type === 'inclusion') {
            // Déplacer tous vers le même groupe
            $targetGroup = reset($currentGroups);
            
            foreach ($participantNames as $name) {
                if ($currentGroups[$name] !== $targetGroup) {
                    // Retirer du groupe actuel
                    $currentGroup = $currentGroups[$name];
                    $key = array_search($name, $groups[$currentGroup]);
                    if ($key !== false) {
                        unset($groups[$currentGroup][$key]);
                        $groups[$currentGroup] = array_values($groups[$currentGroup]);
                    }
                    
                    // Ajouter au groupe cible
                    $groups[$targetGroup][] = $name;
                }
            }
            
            return true;
        } else {
            // Exclusion : séparer les participants
            $usedGroups = array_values($currentGroups);
            $availableGroups = array_diff(array_keys($groups), $usedGroups);
            
            if (count($availableGroups) < count($participantNames) - 1) {
                return false; // Pas assez de groupes disponibles
            }
            
            $targetGroups = array_merge([$usedGroups[0]], array_slice($availableGroups, 0, count($participantNames) - 1));
            
            foreach ($participantNames as $index => $name) {
                $currentGroup = $currentGroups[$name];
                $targetGroup = $targetGroups[$index];
                
                if ($currentGroup !== $targetGroup) {
                    // Retirer du groupe actuel
                    $key = array_search($name, $groups[$currentGroup]);
                    if ($key !== false) {
                        unset($groups[$currentGroup][$key]);
                        $groups[$currentGroup] = array_values($groups[$currentGroup]);
                    }
                    
                    // Ajouter au nouveau groupe
                    $groups[$targetGroup][] = $name;
                }
            }
            
            return true;
        }
    }
}

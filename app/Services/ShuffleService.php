<?php

namespace App\Services;

class ShuffleService
{
    public function fisherYatesShuffle(array $items): array
    {
        $shuffled = $items;
        $count = count($shuffled);
        
        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            
            $temp = $shuffled[$i];
            $shuffled[$i] = $shuffled[$j];
            $shuffled[$j] = $temp;
        }
        
        return $shuffled;
    }

    public function suggestOptimalGroupSizes(int $participantCount): array
    {
        $suggestions = [];
        $maxSize = (int) sqrt($participantCount);
        
        for ($size = 2; $size <= $maxSize; $size++) {
            $groups = floor($participantCount / $size);
            $remainder = $participantCount % $size;
            $penalty = $remainder / $size;
            
            $suggestions[] = [
                'size' => $size,
                'groups' => $groups,
                'remainder' => $remainder,
                'penalty' => $penalty,
            ];
        }
        
        usort($suggestions, fn($a, $b) => $a['penalty'] <=> $b['penalty']);
        
        return array_slice($suggestions, 0, 3);
    }
}

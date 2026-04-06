<?php

namespace App\Services;

class HashService
{
    public function generateSeed(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function buildHashInput(array $participants, string $seed, string $timestamp, array $parameters): string
    {
        sort($participants);
        $participantsString = implode(',', $participants);
        $parametersJson = json_encode($parameters);
        
        return "{$participantsString}|{$seed}|{$timestamp}|{$parametersJson}";
    }

    public function generateHash(string $input): string
    {
        return hash('sha256', $input);
    }

    public function verifyHash(array $participants, string $seed, string $timestamp, array $parameters, string $expectedHash): bool
    {
        $input = $this->buildHashInput($participants, $seed, $timestamp, $parameters);
        $calculatedHash = $this->generateHash($input);
        
        return hash_equals($expectedHash, $calculatedHash);
    }
}

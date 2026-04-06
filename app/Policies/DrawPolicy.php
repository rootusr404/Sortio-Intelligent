<?php

namespace App\Policies;

use App\Models\Draw;
use App\Models\User;

class DrawPolicy
{
    public function view(User $user, Draw $draw): bool
    {
        return $user->id === $draw->user_id;
    }

    public function delete(User $user, Draw $draw): bool
    {
        return $user->id === $draw->user_id;
    }
}

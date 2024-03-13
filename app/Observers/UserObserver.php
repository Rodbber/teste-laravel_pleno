<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $model)
    {
        $userName = $model->name;
        Log::info("Usuário $userName criado");
    }

    public function updated(User $model)
    {
        $userName = $model->name;
        Log::info("Usuário $userName atualizado");
    }

    public function deleted(User $model)
    {
        $userName = $model->name;
        Log::info("Usuário $userName excluído");
    }
}

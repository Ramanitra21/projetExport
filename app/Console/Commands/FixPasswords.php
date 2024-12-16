<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixPasswords extends Command
{
    protected $signature = 'fix:passwords';
    protected $description = 'Répare les mots de passe hachés incorrectement';

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                continue;
            }

            // Mettre à jour avec un mot de passe correctement haché
            $user->password = Hash::make($user->password);
            $user->save();

            $this->info("Mot de passe corrigé pour l'utilisateur : {$user->email}");
        }

        $this->info("Tous les mots de passe ont été vérifiés.");
    }
}

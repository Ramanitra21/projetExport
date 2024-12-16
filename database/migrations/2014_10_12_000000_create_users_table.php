<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('age');
            $table->enum('sexe', ['Homme', 'Femme', 'Autre']);
            $table->string('email')->unique();
            $table->text('adresse');
            $table->string('nationalite');
            $table->string('password'); // Changement de mot_de_passe à password
            $table->timestamp('email_verified_at')->nullable(); // Vérification email
            $table->rememberToken(); // Fonctionnalité "Se souvenir de moi"
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

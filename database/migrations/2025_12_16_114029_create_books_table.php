<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('designation')->unique()->required();
            $table->text('description');
            $table->string('type')->default('Texte');
            $table->string('langue')->default('Francais');
            $table->string('editeur')->default('Anonyme');
            $table->string('categorie')->default('Nouveau');
            $table->double('prix')->default(0);
            $table->string('auteur')->default('Anonyme');
            $table->date('annee');
            $table->string('cover')->default('default-book.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

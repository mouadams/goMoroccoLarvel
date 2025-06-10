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
    Schema::create('activities', function (Blueprint $table) {
        $table->id(); // unsignedBigInteger par défaut
        $table->string('name');
        $table->text('description');
        $table->string('image');
        
        // Assure que stade_id est signé, comme stades.id
        $table->integer('stade_id');

        $table->string('category');
        $table->decimal('price', 8, 2);
        $table->string('address');
        $table->decimal('rating', 3, 1)->nullable();
        $table->timestamps();

        // ✅ Ajouter la contrainte foreign key maintenant que les types match
        $table->foreign('stade_id')
              ->references('id')
              ->on('stades')
              ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

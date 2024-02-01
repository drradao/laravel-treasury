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
        Schema::create('treasury_vaults', function (Blueprint $table) {
            $table->id();

            // Uncomment one of the following lines to use a different type for the owner's ID.
            $table->morphs('owner');
            // $table->ulidMorphs('owner');
            // $table->uuidMorphs('owner');

            $table->string('currency', 64);
            $table->unsignedMediumInteger('balance')->default(0);

            $table->unique(['owner_type', 'owner_id', 'currency']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_vaults');
    }
};

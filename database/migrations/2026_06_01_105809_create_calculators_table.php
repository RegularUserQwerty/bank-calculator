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
    Schema::create('calculators', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->string('code');

        $table->decimal('rate', 5, 2)->default(0);

        $table->string('result_text')
              ->default('Ежемесячный платеж');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculators');
    }
};

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
        Schema::create('produse', function (Blueprint $table) {
            $table->uuid('sku')->unique()->primary();
            $table->string('nume');
            $table->text('url_imagine')->nullable();
            $table->string('categorie')->nullable();
            $table->string('ean')->nullable();
            $table->decimal('pret_fara_tva',12,2)->unsigned()->default(0);
            $table->integer('stoc')->default(0);
            $table->string('brand')->nullable();
            $table->text('descriere')->nullable();
            $table->text('atribute_produs')->nullable();
            $table->string('pret_pj_1')->nullable();

            $table->boolean('new')->default(false)->nullable();
            $table->boolean('price_update')->default(false)->nullable();
            $table->boolean('stock_update')->default(false)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produse');
    }
};

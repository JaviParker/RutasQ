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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pedido_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedidoid')->constrained('pedido')->onDelete('cascade');
            $table->foreignId('productoid')->constrained('producto')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamps();
        });
        
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('pedidoid');
            $table->foreignId('clienteid')->constrained('users')->onDelete('cascade'); // Relación con cliente
            $table->date('pedido_fecha');
            $table->decimal('pedido_total', 8, 2);
            $table->boolean('pedido_por_confirmar')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};

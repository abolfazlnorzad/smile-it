<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('transaction_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('amount', 20, 0);
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};

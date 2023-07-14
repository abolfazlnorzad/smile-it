<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('transaction_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUlid('account_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('amount', 20, 0)->default(0);
            $table->decimal('balance_after_transaction', 20, 0)->default(0);
            $table->enum("type",["deposit","withdraw"]);
            $table->string('description')->nullable();
            $table->boolean('is_commission')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};

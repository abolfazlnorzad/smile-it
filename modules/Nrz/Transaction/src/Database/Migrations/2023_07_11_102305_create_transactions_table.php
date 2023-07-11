<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("type");
            $table->foreignUlid("transaction_id")->nullable()->constrained("transactions","id")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUlid("send_id")->constrained("customers","id")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUlid("receiver_id")->constrained("customers","id")->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('amount', 20, 0);
            $table->string('res_number',30)->unique();
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name',100)->default(\Nrz\Account\Enums\AccountNameEnum::GENERAL->value);
            $table->string('account_number',30);
            $table->foreignUlid('customer_id')->constrained("customers","id")
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('balance', 20, 0)->default(0);
            $table->string('bic',7); // Bank Identifier Code
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

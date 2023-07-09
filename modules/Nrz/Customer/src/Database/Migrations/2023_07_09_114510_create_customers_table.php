<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->string("national_code",15)->unique();
            $table->string("phone_number",15);
            $table->text("address");
            $table->string("zip_code",15);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

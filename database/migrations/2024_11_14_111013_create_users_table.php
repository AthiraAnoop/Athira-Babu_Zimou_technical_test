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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-increment primary key
            $table->string('name'); // User name
            $table->string('email')->unique(); // User email (unique)
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // User password
            $table->rememberToken(); // Remember me token
            $table->timestamps(); // Created and updated timestamps
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

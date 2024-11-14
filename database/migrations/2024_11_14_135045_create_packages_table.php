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
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('package_id'); // Auto-increment primary key
            $table->string('tracking_code')->unique(); // Unique tracking code
            $table->string('name'); // Package name
            $table->bigInteger('store_id')->unsigned(); // Foreign key for stores
            $table->bigInteger('client_id')->unsigned(); // Foreign key for users
            $table->string('status'); // Package status
            $table->string('delivery_type'); // Delivery type
            $table->timestamps(); // Created and updated timestamps

            // Foreign keys
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

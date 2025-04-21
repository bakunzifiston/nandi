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
        Schema::create('milk_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained()->onDelete('cascade');
            $table->dateTime('date_time');
            $table->decimal('quantity_collected', 8, 2);
            $table->enum('quality_check', ['Accepted', 'Rejected']);
            $table->decimal('rejected_quantity', 8, 2)->nullable();
            $table->string('rejection_reason')->nullable();
            $table->decimal('total_accepted_milk', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_collections');
    }
};

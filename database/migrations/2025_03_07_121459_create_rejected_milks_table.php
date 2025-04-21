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
        Schema::create('rejected_milks', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_rejection');
            $table->foreignId('farmer_id')->constrained()->onDelete('cascade');
            $table->foreignId('milk_collection_id')->constrained()->onDelete('cascade'); 
            $table->decimal('quantity_rejected', 8, 2);
            $table->string('rejection_reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejected_milks');
    }
};

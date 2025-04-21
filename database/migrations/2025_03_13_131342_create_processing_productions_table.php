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
        Schema::create('processing_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('milk_collection_id')->constrained()->onDelete('cascade'); 
            $table->date('date_of_processing');
            $table->decimal('milk_used', 8, 2);
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Links to Product
            $table->integer('quantity_produced');
            $table->string('batch_number');
            $table->decimal('wastage', 8, 2)->nullable();
            $table->string('wastage_reason')->nullable();
            $table->string('ingredient')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_productions');
    }
};

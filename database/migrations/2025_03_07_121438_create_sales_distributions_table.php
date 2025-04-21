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
        
            Schema::create('sales_distributions', function (Blueprint $table) {
                $table->id();
                $table->date('sales_date');
                $table->foreignId('processing_production_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('finished_good_id')->constrained()->onDelete('cascade');
                $table->integer('quantity_sold');
                $table->string('customer_retailer_name');
                $table->decimal('price_per_unit', 10, 2);
                $table->decimal('total_sales', 10, 2);
                $table->decimal('amount_paid', 10, 2)->nullable(); // Nullable if not always paid
                $table->enum('delivery_status', ['Pending', 'Delivered', 'Returned'])->default('Pending');
                $table->string('payment_method')->nullable(); // Change to string if it's a payment method type
                $table->boolean('loan_status')->default(false);
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_distributions');
    }
};

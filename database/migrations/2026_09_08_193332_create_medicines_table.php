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
        Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('barcode')->unique()->nullable();
        $table->decimal('purchase_price', 8, 2);
        $table->decimal('selling_price', 8, 2);
        $table->integer('stock_quantity');
        $table->date('expire_date');
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

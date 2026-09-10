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
        if (Schema::hasColumns('medicines', ['barcode', 'expiry_date'])) {
            return;
        }

        Schema::table('medicines', function (Blueprint $table) {
            if (! Schema::hasColumn('medicines', 'barcode')) {
                $table->string('barcode')->nullable()->unique()->after('name');
            }
            if (! Schema::hasColumn('medicines', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('stock_quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['barcode', 'expiry_date']);
        });
    }
};
